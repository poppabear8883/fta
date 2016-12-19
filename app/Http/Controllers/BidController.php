<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Repositories\BidRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BidController extends Controller
{

    private $repo;

    private $html;

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
        return view('new');
    }

    public function createPost(Request $request) {
        $this->validate($request, [
            'itemUrl' => 'required|url'
        ]);

        $url = $request->get('itemUrl');
        $html = $this->repo->Htmldom($url);

        $data = $html->getRemoteData();
        $name = '';
        if(array_has($data, ['Description']))
        {
            preg_match('/^(?>\S+\s*){1,6}/', $data['Description'], $match);
            $name = $match[0];
        }

        return view('new', [
            'data' => $data,
            'url' => $url,
            'cbid' => $html->getRemoteCurBid(),
            'edate' => $html->getRemoteEndDate(),
            'loc' => $html->getRemoteLocation(),
            'name' => $name,
            'notes' => $html->getRemoteDetails()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $uid = auth()->user()->id;
        $timezone = auth()->user()->timezone;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('datetime'), $timezone)->setTimezone('UTC');

        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'datetime' => 'required',
            'location' => 'required',
            'pickup' => 'required',
            'cur_bid' => 'required'
        ]);

        Bid::create([
            'user_id' => $uid,
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'datetime' => $datetime,
            'location' => $request->get('location'),
            'pickup' => $request->get('pickup'),
            'notes' => $request->get('notes'),
            'cur_bid' => $request->get('cur_bid'),
            'max_bid' => $request->get('max_bid')
        ]);

        \Session::flash('flash_message', 'Bid successfully added!');

        return redirect()->back();
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
        $bid = Bid::findOrFail($id);

        return view('edit')->withBid($bid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $timezone = auth()->user()->timezone;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('datetime'), $timezone)->setTimezone('UTC');

        $bid = Bid::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'datetime' => 'required',
            'location' => 'required',
            'pickup' => 'required',
            'cur_bid' => 'required',
            'max_bid' => 'required'
        ]);

        $bid->fill([
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'datetime' => $datetime,
            'location' => $request->get('location'),
            'pickup' => $request->get('pickup'),
            'notes' => $request->get('notes'),
            'cur_bid' => $request->get('cur_bid'),
            'max_bid' => $request->get('max_bid')
        ])->save();

        \Session::flash('flash_message', 'Successful!');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateWon($id, Request $request)
    {
        $bid = Bid::findOrFail($id);

        $this->validate($request, [
            'won' => 'required'
        ]);

        $input = $request->all();

        $bid->fill($input)->save();

        \Session::flash('flash_message', 'Successful!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $bid = Bid::findOrFail($id);

        $bid->delete();

        \Session::flash('flash_message', 'Bid successfully deleted!');

        return redirect()->back();
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
