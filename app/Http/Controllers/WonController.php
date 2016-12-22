<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Bid;

use App\Repositories\UserBidsRepositoryInterface;

class WonController extends Controller
{
    private $userBidsRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserBidsRepositoryInterface $ubids)
    {
        $this->userBidsRepository = $ubids;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = $this->userBidsRepository->getActiveCount();
        return view('pages.won',['active' => $active]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return $this->userBidsRepository->getWonDataTable();
    }
}
