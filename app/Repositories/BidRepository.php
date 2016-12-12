<?php

namespace App\Repositories;

use App\Bid;
use Yajra\Datatables\Datatables;
use Yangqi\Htmldom\Htmldom;

class BidRepository implements BidRepositoryInterface {

    /**
     * @return mixed
     */
    public function getActiveCount()
    {
        return Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '0']
        ])->get();
    }

    /**
     * @return mixed
     */
    public function getWonCount() {
        return Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '1']
        ])->get();
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

    /**
     * @param $url
     * @return array
     */
    public function getRemoteData($url) {
        $html = new Htmldom($url);

        $pattern = '/<br\s?\/?>/';

        $form = $html->find('form[name=bidform]');
        $subject = $form[0]
            ->children(1)
            ->children(1)
            ->children(2)
            ->innertext;

        $result = preg_split($pattern, trim($subject));

        //dd($result);

        $itemArray = [];

        $pattern = '/\s?:\s?/';

        foreach ($result as $item) {
            if($item != "") {
                $keyValuePairs = preg_split($pattern, $item);

                //dd($keyValuePairs);

                $key = preg_replace('/<\/?b>/', '', $keyValuePairs[0]);
                $key = str_replace(' Information', '', trim($key));
                $key = str_replace('Item ', '', trim($key));
                $key = str_replace(' #', '', trim($key));

                if(trim($key) == 'Front Page') {
                    break;
                }

                $value = $keyValuePairs[1];

                $itemArray[] = [trim($key) => trim($value)];
            }
        }

        //dd(array_collapse($itemArray));

        return array_collapse($itemArray);
    }
}