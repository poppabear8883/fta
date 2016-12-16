<?php

namespace App\Http\Controllers;

use App\Repositories\BidRepositoryInterface;

class HomeController extends Controller
{

    private $repo;

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
}
