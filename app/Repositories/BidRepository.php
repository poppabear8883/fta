<?php

namespace App\Repositories;

use App\Bid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BidRepository implements BidRepositoryInterface {

    use ValidatesRequests;

    private $bid;

    public function __construct(Bid $bid) {
        $this->bid = $bid;
    }

    public function store(array $data)
    {
        $uid = auth()->user()->id;
        $tz = auth()->user()->timezone;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $data['datetime'], $tz)->setTimezone('UTC');

        return Bid::create([
            'user_id' => $uid,
            'name' => $data['name'],
            'url' => $data['url'],
            'datetime' => $datetime,
            'location' => $data['location'],
            'pickup' => $data['pickup'],
            'notes' => $data['notes'],
            'cur_bid' => $data['cur_bid'],
            'max_bid' => $data['max_bid']
        ]);
    }

    public function findOrFail($id)
    {
        return Bid::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $timezone = auth()->user()->timezone;
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $data['datetime'], $timezone)->setTimezone('UTC');

        $bid = $this->findOrFail($id);

        return $bid->fill([
            'name' => $data['name'],
            'url' => $data['url'],
            'datetime' => $datetime,
            'location' => $data['location'],
            'pickup' => $data['pickup'],
            'notes' => $data['notes'],
            'cur_bid' => $data['cur_bid'],
            'max_bid' => $data['max_bid']
        ])->save();
    }

    public function updateWon($id, array $data)
    {
        $bid = $this->findOrFail($id);
        return $bid->fill($data)->save();
    }

    public function destroy($id)
    {
        $bid = $this->findOrFail($id);
        $bid->delete();
    }

    public function validateForCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'datetime' => 'required',
            'location' => 'required',
            'pickup' => 'required',
            'cur_bid' => 'required'
        ]);

        return $this;
    }

    public function validateForUpdate(Request $request)
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

        return $this;
    }

    public function validateForUpdatingWonValue(Request $request)
    {
        $this->validate($request, [
            'won' => 'required'
        ]);

        return $this;
    }
}
