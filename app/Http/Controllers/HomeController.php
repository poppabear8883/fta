<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Bid;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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

        $won = Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '1']
        ])->get();
        $max_amount = 0;

        $m_bids = Bid::select(['max_bid'])
            ->where([
                ['user_id', '=', \Auth::user()->id],
                ['won', '=', '0']
            ])->get();

        //dd($cur_bids[0]->cur_bid);

        foreach($m_bids as $b) {
            $max_amount += $b->max_bid;
        }

        return view('home',['won' => $won, 'max_amount' => $max_amount]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $bids = Bid::where([
                ['user_id', '=', \Auth::user()->id],
                ['won', '=', 0]
            ])
            ->get();
        return Datatables::of($bids)->make(true);
    }
}
