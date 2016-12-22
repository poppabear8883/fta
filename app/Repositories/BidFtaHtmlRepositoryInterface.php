<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface BidFtaHtmlRepositoryInterface {
    public function getFromUrl($url);
    public function CurrentBid();
    public function Data();
    public function Details();
    public function EndDate($timezone='UTC');
    public function Location();
    public function Name();
    public function remote_data(Request $request, $tz='UTC');
}