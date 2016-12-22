<?php

namespace App\Http\Controllers;

use App\Mail\QuickEmail;
use App\Repositories\UserBidsRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    /**
     * Bid Repository Dependency
     * @var UserBidsRepositoryInterface
     */
    private $bid;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserBidsRepositoryInterface $bid)
    {
        $this->bid = $bid;
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guest()) {
            return view('welcome');
        }

        $max_total = $this->bid->getMaxBidsAmount();
        $cur_total = $this->bid->getCurBidsAmount();
        $mBudget_percentage = ($max_total/auth()->user()->budget)*100;
        $cBudget_percentage = ($cur_total/auth()->user()->budget)*100;

        return view('pages.dashboard',[
            'recently_won' => $this->bid->getRecentlyWon(),
            'won_count' => $this->bid->getWonCount(),
            'won_amount' => $this->bid->getWonAmount(),
            'active_count' => $this->bid->getActiveCount(),
            'max_total' => $max_total,
            'cur_total' => $cur_total,
            'mBudget_percentage' => $mBudget_percentage,
            'cBudget_percentage' => $cBudget_percentage
        ]);
    }

    public function postQuickEmail(Request $request) {
        $user = User::find(auth()->user()->id);
        Mail::to($request->get('email'))->send(new QuickEmail($user, $request));
        \Session::flash('flash_message', 'Email has been sent! Please allow 24hrs for a response.');
        return redirect()->back();
    }

}
