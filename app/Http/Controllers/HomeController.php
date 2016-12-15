<?php

namespace App\Http\Controllers;

use App\Repositories\BidRepositoryInterface;

class HomeController extends Controller
{

    private $repo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BidRepositoryInterface $repo)
    {
        $this->repo = $repo;
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

        return view('home',[
            'recently_won' => $this->repo->getRecentlyWon(),
            'won_count' => $this->repo->getWonCount(),
            'active_count' => $this->repo->getActiveCount(),
            'max_total' => $this->repo->getMaxBidsAmount(),
            'cur_total' => $this->repo->getCurBidsAmount()
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return $this->repo->getDataTable();
    }
}
