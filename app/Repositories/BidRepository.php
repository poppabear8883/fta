<?php

namespace App\Repositories;

use App\Bid;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BidRepository implements BidRepositoryInterface {

    private $bid;

    public function __construct(Bid $bid) {
        $this->bid = $bid;
    }


    public function store(Request $request)
    {
        $uid = auth()->user()->id;
        $tz = auth()->user()->timezone;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('datetime'), $tz)->setTimezone('UTC');

        return Bid::create([
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
    }

    public function findOrFail($id)
    {
        return Bid::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $timezone = auth()->user()->timezone;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('datetime'), $timezone)->setTimezone('UTC');

        $bid = $this->findOrFail($id);

        return $bid->fill([
            'name' => $request->get('name'),
            'url' => $request->get('url'),
            'datetime' => $datetime,
            'location' => $request->get('location'),
            'pickup' => $request->get('pickup'),
            'notes' => $request->get('notes'),
            'cur_bid' => $request->get('cur_bid'),
            'max_bid' => $request->get('max_bid')
        ])->save();
    }

    public function updateWon($id, Request $request)
    {
        $bid = $this->findOrFail($id);
        $input = $request->all();
        return $bid->fill($input)->save();
    }

    public function destroy($id)
    {
        $bid = $this->findOrFail($id);
        $bid->delete();
    }
}
