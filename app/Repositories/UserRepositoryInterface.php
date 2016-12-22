<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface UserRepositoryInterface {
    public function findOrFail($id);
    public function create(array $data);
    public function update($id, array $data);
    public function destroy($id);
}