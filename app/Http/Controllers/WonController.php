<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Bid;


class WonController extends Controller
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
        $active = Bid::where([
            ['user_id', '=', \Auth::user()->id],
            ['won', '=', '0']
        ])->get();
        return view('won',['active' => $active]);
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
                ['won', '=', 1]
            ])
            ->get();
        return Datatables::of($bids)->make(true);
    }
}
