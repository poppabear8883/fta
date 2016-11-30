<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $won = Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '1']
        ])->get();
        return view('home',['won' => $won]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $users = Bid::select(['url', 'won', 'datetime', 'name', 'location', 'cur_bid', 'max_bid'])
            ->where('user_id', \Auth::user()->id)
            ->get();
        return Datatables::of($users)->make();
    }
}
