<?php

namespace App\Http\Controllers;

use App\Repositories\BidRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Bid Repository Dependency
     * @var BidRepositoryInterface
     */
    private $bid;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BidRepositoryInterface $bid)
    {
        $this->bid = $bid;
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guest()) {
            return view('welcome');
        }

        return view('pages.dashboard',[
            'recently_won' => $this->bid->getRecentlyWon(),
            'won_count' => $this->bid->getWonCount(),
            'active_count' => $this->bid->getActiveCount(),
            'max_total' => $this->bid->getMaxBidsAmount(),
            'cur_total' => $this->bid->getCurBidsAmount()
        ]);
    }

}
