<?php

namespace App\Http\Controllers;


use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HelperController extends Controller
{
    public const HOME='/helper/dashboard';

    public function __construct()
    {
        $this->middleware('auth')->except(['register', 'login']);
    }

    public function registrationForm()
    {
        if (Auth::check()) {
            return redirect()->intended(self::HOME);
        }

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

        $this->guard()->login($user, true);

        return $this->sendLoginResponse($request);
    }

    public function loginForm()
    {
        return view('helpers.login');
    }

    public function dashboard()
    {
        return view('helpers.dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        $credentials = $request->only('name', 'phone');
        if ($this->guard()->attempt($credentials, $request->filled('remember')))  {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('helpers');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return $request->wantsJson()
                    ? new Response('', 204)
                    : redirect()->intended(self::HOME);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'name' => [trans('auth.failed')],
        ]);
    }
}
