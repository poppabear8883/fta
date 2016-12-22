<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->middleware('auth');
        $this->userRepository = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = $this->userRepository->findOrFail(auth()->user()->id);
        return view('pages.profile',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'budget' => 'required',
            'bidder_number' => 'required|numeric',
            'phone_number' => 'required|numeric',
        ]);

        $input = $request->all();
        $this->userRepository->update($id, $input);

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
        //
    }
}
