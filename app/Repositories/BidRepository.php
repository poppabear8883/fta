<?php

namespace App\Repositories;

use App\Repositories\BidRepositoryInterface;
use App\Bid;
use Yajra\Datatables\Datatables;

class BidRepository implements BidRepositoryInterface {

    public function getActiveCount()
    {
        return Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '0']
        ])->get();
    }

    public function getWonCount() {
        return Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '1']
        ])->get();
    }

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

    public function getDataTable() {
        $bids = Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', 0]
        ])->get();
        return Datatables::of($bids)->make(true);
    }

    public function getWonDataTable()
    {
        $bids = Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', 1]
        ])->get();
        return Datatables::of($bids)->make(true);
    }
}