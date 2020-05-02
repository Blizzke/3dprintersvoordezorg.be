<?php

namespace App\Http\Controllers;


use App\Helper;
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

    public function register(Request $request)
    {
        $request->validate($this->helperValidationRules());

        $user = Helper::create($request->all());

        $this->guard()->login($user, true);

        return $this->sendLoginResponse($request);
    }

    protected function helperValidationRules($addName = true, $emailExcept = null)
    {
        $rules = $addName ? ['name' => 'required|unique:helpers'] : [];
        return $rules + [
                'display_name' => 'required',
                'zip' => 'required',
                'city' => 'required',
                'email' => 'nullable|email|unique:helpers,email' . ($emailExcept ? ',' . $emailExcept : ''),
                'phone' => 'required_without:mobile',
                'mobile' => 'required_without:phone',
            ];
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

    public function locked()
    {
        return view('helpers.locked', ['user' => Auth::user()]);
    }

    public function unlock(Helper $helper)
    {
        /** @var Helper $auth */
        $auth = Auth::user();
        $authName = $auth->display_name;

        if (!$auth->hasFeature('auth:unlocker')) {
            do_log($auth, "$authName tried to access the account unlock page for helper {$helper->id} ({$helper->name})", LOG_ERR);
            return redirect(self::HOME);
        }
        return view('helpers.unlock', ['user' => $helper]);
    }

    public function doUnlock(Helper $helper, Request $request)
    {
        /** @var Helper $auth */
        $auth = Auth::user();
        $authName = $auth->display_name;

        if (!$auth->hasFeature('auth:unlocker')) {
            // Doesn't have access...
            do_log($auth, "$authName tried to access the account do-unlock page for helper {$helper->id} (POST)", LOG_ERR);
            return redirect(self::HOME);
        }

        if ($request->has('block')) {
            do_log($auth, "$authName voted to keep the {$helper->id} ({$helper->name}) account blocked", LOG_WARNING);
            return redirect(self::HOME);
        }

        $request->validate(['chat_name' => 'required']);

        $helper->chat_name = $request->chat_name;
        $helper->save();
        $helper->registerFeature('account:unlocked');

        do_log($auth, "$authName has unlocked the account of helper {$helper->id} ({$helper->name})");
        return redirect(self::HOME);
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
        /** @var Helper $user */
        $user = Auth::user();
        if (!$user->hasFeature('account:unlocked')) {
            // Obligate every helper
            return redirect('/helper/locked');
        }
        if (!$user->hasFeature('agreement:who_what_where')) {
            return redirect('/helper/how-what-where');
        }
        return view('helpers.dashboard', ['user' => $user]);
    }

    public function howWhatWhere()
    {
        return view('helpers.how_what_where');
    }

    public function confirmHowWhatWhere()
    {
        Auth::user()->registerFeature('agreement:who_what_where');
        return redirect()->back();
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
        $user->registerFeature('notification:please_add_material');

        $request->validate($this->helperValidationRules(false, $user->id));

        $user->update($request->all());

        if ($request->has('feature')) {
            // Fetch pre-existing non-modifiables (so we don't lose them in the sync)
            $nonModifiables = $user->features()->where('modifiable', 0)
                ->select('features.id')->get()->map->only('id')->pluck('id');
            $selected = array_keys(array_filter($request->get('feature', []), function ($value) {
                return $value == '1';
            }));
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
