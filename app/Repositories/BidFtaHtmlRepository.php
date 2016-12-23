<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Yangqi\Htmldom\Htmldom;

class BidFtaHtmlRepository implements BidFtaHtmlRepositoryInterface {

    use ValidatesRequests;

    private $Htmldom;

    private $html;

    public function __construct(Htmldom $htmldom) {
        $this->Htmldom = $htmldom;
    }

    /**
     * @param $url
     * @return $this
     */
    public function getFromUrl($url)
    {
        $this->html = $this->Htmldom->file_get_html($url);
        return $this;
    }

    public function CurrentBid()
    {
        $get = $this->html->find('form[name=bidform]')[0];
        return $get->children(1)->children(1)->children(5)->innertext;
    }

    public function EndDate($timezone='UTC')
    {
        $get = $this->html->find('table[id=TableTop]')[0];

        $pattern = '/\s?-\s?/';

        $subject = strip_tags(
            $get
                ->children(0)
                ->children(1)
                ->innertext
        );

        $arr = preg_split($pattern, trim($subject));
        $pattern = '/(?:.*[0-9]{1,2}\:[0-9]{1,2})(?:\s|)(?:am|pm)/i';
        preg_match($pattern, $arr[3], $result);

        return Carbon::createFromFormat('F jS, Y g:i A', $result[0], $timezone)
            ->setTimezone($timezone)
            ->format('Y-m-d H:i:s');
    }

    public function Location()
    {
        $get = $this->html->find('table[id=TableTop]')[0];
        $pattern = '/\s?-\s?/';

        $subject = strip_tags(
            $get
                ->children(0)
                ->children(1)
                ->innertext
        );

        $arr = preg_split($pattern, trim($subject));
        $result = $arr[2];

        preg_match('/^(?>\S+\s*){1,4}/', $result, $match);

        return rtrim($match[0]);
    }

    /**
     * @param $url
     * @return array
     */
    public function Data()
    {
        $get = $this->html->find('form[name=bidform]')[0];

        $pattern = '/<br\s?\/?>/';

        $subject = $get
            ->children(1)
            ->children(1)
            ->children(2)
            ->innertext;

        $result = preg_split($pattern, trim($subject));

        $itemArray = [];

        $pattern = '/\s?:\s?/';

        foreach ($result as $item) {
            if ($item != "") {
                $keyValuePairs = preg_split($pattern, $item);

                $key = preg_replace('/<\/?b>/', '', $keyValuePairs[0]);

                if (str_contains($key, [
                    ' Description',
                    ' Information',
                    ' Location'
                ])) {
                    $key = substr(stristr($key, " "), 1);
                }

                if (str_contains($key, ['Load '])) {
                    $key = substr(stristr($key, " ", true), 0);
                }

                if (trim($key) == 'Front Page' || trim($key) == 'Contact') {
                    break;
                }

                $value = $keyValuePairs[1];
                $value = preg_replace('/[^A-Za-z0-9\s\-.]/', '', $value);

                $itemArray[] = [trim($key) => trim($value)];
            }
        }

        return array_collapse($itemArray);
    }

    public function Name() {
        if(array_has($this->Data(), ['Description']))
        {
            preg_match('/^(?>\S+\s*){1,2}/', $this->Data()['Description'], $match);
            return $match[0];
        }

        return '';
    }

    public function Details()
    {
        $data = $this->Data();
        $details = '';

        foreach ($data as $k => $v) {
            $details .= $k . ': ' . $v . "\n";
        }

        return $details;
    }

    public function remote_data(Request $request, $tz='UTC')
    {
        $this->validate($request, [
            'itemUrl' => 'required|url'
        ]);

        $html = $this->getFromUrl($request->get('itemUrl'));

        return [
            'data' => $html->Data(),
            'url' => $request->get('itemUrl'),
            'cbid' => $html->CurrentBid(),
            'edate' => $html->EndDate($tz),
            'loc' => $html->Location(),
            'name' => $html->Name(),
            'notes' => $html->Details()
        ];
    }
}