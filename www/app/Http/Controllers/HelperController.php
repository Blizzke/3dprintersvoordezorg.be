<?php

namespace App\Http\Controllers;


use App\Feature;
use App\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HelperController extends Controller
{
    public const HOME = '/helper/dashboard';

    public function __construct()
    {
        $this->middleware('auth:helpers')->except('registrationForm', 'register', 'loginForm', 'login');
    }

    public function registrationForm()
    {
        if (Auth::check()) {
            return redirect()->intended(self::HOME);
        }

        return view('helpers.register', ['countries' => Helper::COUNTRIES]);
    }

    protected function helperValidationRules($addName = true, $emailExcept = null)
    {
        $rules = $addName ? ['name' => 'required|unique:helpers'] : [];
        return $rules + [
            'display_name' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'email' => 'nullable|email|unique:helpers,email'. ($emailExcept ? ',' . $emailExcept : ''),
            'phone' => 'required_without:mobile',
            'mobile' => 'required_without:phone',
        ];
    }

    public function register(Request $request)
    {
        $request->validate($this->helperValidationRules());

        $user = Helper::create($request->all());

        $this->guard()->login($user, true);

        return $this->sendLoginResponse($request);
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

    public function loginForm()
    {
        return view('helpers.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        $credentials = $request->only('name', 'phone');
        if ($this->guard()->attempt($credentials, $request->filled('remember'))) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'name' => [trans('auth.failed')],
        ]);
    }

    public function dashboard()
    {
        return view('helpers.dashboard', ['user' => Auth::user()]);
    }

    public function howWhatWhere()
    {
        return view('helpers.how_what_where');
    }

    public function profileForm()
    {
        return view('helpers.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        /** @var Helper $user */
        $user = Auth::user();
        $user->registerFeature('notification:please_add_features');

        $request->validate($this->helperValidationRules(false, $user->id));

        $user->update($request->all());

        if ($request->has('feature')) {
            // Fetch pre-existing non-modifiables (so we don't lose them in the sync)
            $nonModifiables = $user->features()->where('modifiable', 0)
                ->select('features.id')->get()->map->only('id')->pluck('id');
            $selected = array_keys(array_filter($request->get('feature', []), function($value) {return $value=='1';}));
            $user->features()->sync($nonModifiables->merge($selected));
        }

        return redirect()->route('dashboard');
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
}
