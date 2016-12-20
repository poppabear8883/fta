<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Bid;

use App\Repositories\BidRepositoryInterface;

class WonController extends Controller
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = $this->repo->getActiveCount();
        return view('pages.won',['active' => $active]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return $this->repo->getWonDataTable();
    }
}
