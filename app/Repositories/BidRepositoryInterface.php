<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface BidRepositoryInterface {
    public function findOrFail($id);
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
    public function updateWon($id, Request $request);
}