<?php

namespace App\Http\Controllers;


use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class HelperController extends Controller
{
    public function registrationForm()
    {
        return view('helpers.register', ['countries' => Helper::COUNTRIES]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:helpers',
            'display_name' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'email' => 'nullable|email|unique:helpers',
            'mobile' => 'required',
        ]);

        $input = $request->all();

        $user = Helper::create($input);
        Auth::login($user, true);

        //return ->with('success', 'User created successfully.');
    }

    protected function guard()
    {
        return Auth::guard('helpers');
    }

    public function authenticationForm()
    {
        return view('helpers.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('name', 'phone');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }


}
