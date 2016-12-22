<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface BidRepositoryInterface {
    public function findOrFail($id);
    public function store(array $data);
    public function update($id, array $data);
    public function destroy($id);
    public function updateWon($id, array $data);
    public function validateForCreate(Request $request);
    public function validateForUpdate(Request $request);
    public function validateForUpdatingWonValue(Request $request);

}