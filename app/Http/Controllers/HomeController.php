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
        if(\Auth::guest()) {
            return view('welcome');
        }

        $won = $this->repo->getWonCount();

        $max_amount = $this->repo->getMaxBidsAmount();

        return view('home',[
            'won' => $won,
            'max_amount' => $max_amount
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
