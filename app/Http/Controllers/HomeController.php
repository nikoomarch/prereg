<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('test');
        $this->userRepository = new UserRepository();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function resetPassword()
    {
        return view('auth.passwords.reset');
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password:web',
            'new_password' => 'required|min:6',
            'confirm_password' => 'same:new_password'
        ]);
        $this->userRepository->update(auth()->user(), ['password' => Hash::make($request->new_password)]);
        return back()->with('alert', ['title' => trans('messages.success'), 'message' => trans('messages.updated', ['entity' => 'رمز عبور']), 'icon' => 'success']);
    }

    public function test()
    {
        return "done!";
    }

}
