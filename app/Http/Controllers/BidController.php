<?php

namespace App\Http\Controllers;

use App\Repositories\BidFtaHtmlRepositoryInterface;
use App\Repositories\BidRepositoryInterface;
use App\Repositories\UserBidsRepositoryInterface;
use Illuminate\Http\Request;

class BidController extends Controller
{

    /**
     * BidRepository Instance
     *
     * @var BidRepositoryInterface
     */
    private $bidRepository;

    /**
     * UserBidsRepository Instance
     *
     * @var UserBidsRepositoryInterface
     */
    private $userBidsRepository;

    /**
     * BidftaHtmlRepository Instance
     *
     * @var BidFtaHtmlRepositoryInterface
     */
    private $bidftaHtmlRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BidRepositoryInterface $bid, UserBidsRepositoryInterface $ubids, BidFtaHtmlRepositoryInterface $html)
    {
        $this->bidRepository = $bid;
        $this->userBidsRepository = $ubids;
        $this->bidftaHtmlRepository = $html;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('pages.bids');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.new');
    }

    /**
     * Passes remote data from repository to create form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createFromHtml(Request $request)
    {
        $data = $this->bidftaHtmlRepository->remote_data($request, auth()->user()->timezone);
        return view('pages.new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->bidRepository
            ->validateForCreate($request)
            ->store($request->all());

        \Session::flash('flash_message', 'Bid successfully added!');

        return redirect('bids.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('pages.edit')->withBid($this->bidRepository->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->bidRepository
            ->validateForUpdate($request)
            ->update($id, $request->all());

        \Session::flash('flash_message', 'Successful!');

        return redirect('bids.index');
    }

    /**
     * Update the `won` column for the resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateWon($id, Request $request)
    {
        $this->bidRepository
            ->validateForUpdatingWonValue($request)
            ->updateWon($id, $request->all());

        \Session::flash('flash_message', 'Successful!');

        return redirect('bids.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->bidRepository->destroy($id);

        \Session::flash('flash_message', 'Bid successfully deleted!');

        return redirect('bids.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return $this->userBidsRepository->getDataTable();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }
}
