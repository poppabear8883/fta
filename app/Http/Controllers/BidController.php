<?php

namespace App\Http\Controllers;

use App\Repositories\BidFtaHtmlRepositoryInterface;
use App\Repositories\BidRepositoryInterface;
use App\Repositories\UserBidsRepositoryInterface;
use Illuminate\Http\Request;

class BidController extends Controller
{

    private $bid;

    private $ubids;

    private $html;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BidRepositoryInterface $bid, UserBidsRepositoryInterface $ubids, BidFtaHtmlRepositoryInterface $html)
    {
        $this->bid = $bid;
        $this->ubids = $ubids;
        $this->html = $html;
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

    public function createFromHtml(Request $request) {
        $this->validate($request, [
            'itemUrl' => 'required|url'
        ]);

        $data = $this->html->remote_data($request->get('itemUrl'), auth()->user()->timezone);

        return view('pages.new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'datetime' => 'required',
            'location' => 'required',
            'pickup' => 'required',
            'cur_bid' => 'required'
        ]);

        $this->bid->store($request);

        \Session::flash('flash_message', 'Bid successfully added!');

        return redirect('bids.index');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('pages.edit')->withBid($this->bid->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'datetime' => 'required',
            'location' => 'required',
            'pickup' => 'required',
            'cur_bid' => 'required',
            'max_bid' => 'required'
        ]);

        $this->bid->update($id, $request);

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
        $this->validate($request, [
            'won' => 'required'
        ]);

        $this->bid->updateWon($id, $request);

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
        $this->bid->destroy($id);

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
        return $this->ubids->getDataTable();
    }
}
