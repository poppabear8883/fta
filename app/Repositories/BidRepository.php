<?php

namespace App\Repositories;

use App\Bid;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Yangqi\Htmldom\Htmldom;

class BidRepository implements BidRepositoryInterface {

    private $html;

    private $remoteDateTable;

    private $remoteForm;

    public function __construct() {

    }

    /**
     * @return mixed
     */
    public function getActiveCount()
    {
        return count(Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '0']
        ])->get());
    }

    /**
     * @return mixed
     */
    public function getWonCount() {
        return count(Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '1']
        ])->get());
    }

    /**
     * @return int
     */
    public function getCurBidsAmount()
    {
        $amount = 0;

        $bids = Bid::select(['cur_bid'])
            ->where([
                ['user_id', '=', \Auth::user()->id],
                ['won', '=', '0']
            ])->get()->pluck('cur_bid');

        foreach($bids as $b) {
            $amount += $b;
        }

        return $amount;
    }

    /**
     * @return int
     */
    public function getMaxBidsAmount() {
        $amount = 0;

        $bids = Bid::select(['max_bid'])
            ->where([
                ['user_id', '=', \Auth::user()->id],
                ['won', '=', '0']
            ])->get()->pluck('max_bid');

        foreach($bids as $b) {
            $amount += $b;
        }

        return $amount;
    }

    /**
     * @return mixed
     */
    public function getDataTable() {
        $bids = Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', 0]
        ])->get();
        return Datatables::of($bids)->make(true);
    }

    /**
     * @return mixed
     */
    public function getWonDataTable()
    {
        $bids = Bid::where([
            ['user_id', '=', auth()->user()->id],
            ['won', '=', 1]
        ])->get();
        return Datatables::of($bids)->make(true);
    }

    public function Htmldom($url) {
        $this->html = new Htmldom($url);
        $this->remoteForm = $this->html->find('form[name=bidform]')[0];
        $this->remoteDateTable = $this->html->find('table[id=TableTop]')[0];
        return $this;
    }

    public function getRemoteCurBid() {
        return $this->remoteForm->children(1)->children(1)->children(5)->innertext;
    }

    public function getRemoteEndDate() {
        $pattern = '/\s?-\s?/';

        $subject = strip_tags($this->remoteDateTable
            ->children(0)
            ->children(1)
            ->innertext);

        $arr = preg_split($pattern, trim($subject));
        $result = str_replace(' EST', '', $arr[3]);
        $tz = auth()->user()->timezone;
        $date = Carbon::createFromFormat('F jS, Y g:i A', $result, $tz)
            ->setTimezone($tz)
            ->format('Y-m-d H:i:s');
        return $date;
    }

    public function getRemoteLocation() {
        $pattern = '/\s?-\s?/';

        $subject = strip_tags($this->remoteDateTable
            ->children(0)
            ->children(1)
            ->innertext);

        $arr = preg_split($pattern, trim($subject));
        $result = $arr[2];

        preg_match('/^(?>\S+\s*){1,4}/', $result, $match);

        return rtrim($match[0]);
    }

    /**
     * @param $url
     * @return array
     */
    public function getRemoteData() {
        $pattern = '/<br\s?\/?>/';
        $subject = $this->remoteForm
            ->children(1)
            ->children(1)
            ->children(2)
            ->innertext;

        $result = preg_split($pattern, trim($subject));

        $itemArray = [];

        $pattern = '/\s?:\s?/';

        foreach ($result as $item) {
            if($item != "") {
                $keyValuePairs = preg_split($pattern, $item);

                $key = preg_replace('/<\/?b>/', '', $keyValuePairs[0]);
                $key = str_replace(' Information', '', trim($key));
                $key = str_replace('Item ', '', trim($key));
                $key = str_replace(' #', '', trim($key));

                if(trim($key) == 'Front Page' || trim($key) == 'Contact') {
                    break;
                }

                $value = $keyValuePairs[1];
                $value = preg_replace('/[^A-Za-z0-9\s\-.]/', '', $value);

                $itemArray[] = [trim($key) => trim($value)];
            }
        }

        //dd(array_collapse($itemArray));

        return array_collapse($itemArray);
    }

    public function getRemoteDetails() {
        $data = $this->getRemoteData();
        $details = '';

        foreach($data as $k => $v) {
            $details .= $k .': '.$v."\n";
        }

        return $details;
    }

    public function getRecentlyWon()
    {
        $uid = auth()->user()->id;
        $bids = Bid::select(['name', 'location', 'datetime', 'cur_bid'])
        ->where('user_id', $uid)
        ->where('won', 1)
        ->orderBy('datetime', 'desc')
            ->limit(5)->get();

        return $bids;
    }
}