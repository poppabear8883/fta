<?php

namespace App\Http\Controllers;

use App\Repositories\UserBidsRepositoryInterface;

class HomeController extends Controller
{

    private $repo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserBidsRepositoryInterface $repo)
    {
        $this->repo = $repo;
        $this->middleware('auth');
    }
}
