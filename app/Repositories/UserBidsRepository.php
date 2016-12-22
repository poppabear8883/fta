<?php

namespace App\Repositories;

use App\User;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class UserBidsRepository implements UserBidsRepositoryInterface
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getActiveCount()
    {
        return count($this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', '0')
            ->get());
    }

    /**
     * @return mixed
     */
    public function getWonCount()
    {
        return count($this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', '1')
            ->get());
    }

    /**
     * @return int
     */
    public function getCurBidsAmount()
    {
        $amount = 0;

        $bids = $this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', '0')
            ->get()->pluck('cur_bid');

        foreach ($bids as $b) {
            $amount += $b;
        }

        return $amount;
    }

    /**
     * @return int
     */
    public function getMaxBidsAmount()
    {
        $amount = 0;

        $bids = $this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', '0')
            ->get()->pluck('max_bid');

        foreach ($bids as $b) {
            $amount += $b;
        }

        return $amount;
    }

    public function getWonAmount()
    {
        $amount = 0;

        $bids = $this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', '1')
            ->get()->pluck('cur_bid');

        foreach ($bids as $b) {
            $amount += $b;
        }

        return $amount;
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {
        $bids = $this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', '0')
            ->get();

        return Datatables::of($bids)
            ->addColumn('action', function ($bid) {
                $tz = auth()->user()->timezone;
                $datetime = Carbon::parse($bid->datetime)->setTimezone($tz);
                $now = Carbon::now($tz);
                $ended = false;
                if($datetime >= $now) {
                    $ended = true;
                }
                return view('partials.datatables.actions_column', compact(['bid','ended']))->render();
            })
            ->make(true);
    }

    /**
     * @return mixed
     */
    public function getWonDataTable()
    {
        $bids = $this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', '1')
            ->get();
        return Datatables::of($bids)->make(true);
    }

    public function getRecentlyWon()
    {
        $bids = $this->user
            ->find(auth()->user()->id)
            ->bids()
            ->where('won', 1)
            ->orderBy('datetime', 'desc')
            ->limit(5)->get();

        return $bids;
    }
}