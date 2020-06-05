<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use App\Services\EcolabAuthenticationService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * The service to perform authentication actions
     *
     * @var App\Services\EcolabAuthenticationService
     */
    protected $ecolabAuthenticationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EcolabAuthenticationService $ecolabAuthenticationService, EcolabService $ecolabService)
    {
        $this->middleware('guest')->except('logout');

        $this->ecolabAuthenticationService = $ecolabAuthenticationService;

        parent::__construct($ecolabService);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Receives the authorization result from the API
     * @return \Illuminate\Http\Response
     */
    public function authorization(Request $request)
    {
        if ($request->has('code')) {
            $tokenData = $this->ecolabAuthenticationService->getCodeToken($request->code);

            $userData = $this->ecolabService->getUserInformation();

            $user = $this->registerOrUpdateUser($userData, $tokenData);

            $this->loginUser($user);

            return redirect()->intended('home');
        }

        return redirect()->route('login')->withErrors(['You caneceled the authorization process']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try {
            $tokenData = $this->ecolabAuthenticationService->getPasswordToken($request->email, $request->password);

            $userData = $this->ecolabService->getUserInformation();

            $user = $this->registerOrUpdateUser($userData, $tokenData);

            $this->loginUser($user, $request->has('remember'));

            //dd(Auth::user()->name);

            return redirect()->intended('panel');
        } catch (ClientException $e) {
            $message = $e->getResponse()->getBody();
            if (Str::contains($message, 'invalid_credentials')) {
                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponse($request);
            }

            throw $e;
        }
    }

    /**
     * Creates or updates a user from the API
     * @param  stdClass $userData
     * @param  stdClass $tokenData
     * @return App\User
     */
    public function registerOrUpdateUser($userData, $tokenData)
    {
        //dd($userData);
        return User::updateOrCreate(
            [
                'service_id' => $userData->id,
            ],
            [
                'userCode' => $userData->code,
                'userGrant' => $userData->userType,
                'grant_type' => $tokenData->grant_type,
                'access_token' => $tokenData->access_token,
                'refresh_token' => $tokenData->refresh_token,
                'token_expires_at' => $tokenData->token_expires_at,
            ]
        );
    }

    /**
     * Authenticates a user on the CLient
     * @param  App\User    $user
     * @param  boolean $remember
     * @return void
     */
    public function loginUser($user, $remember = true)
    {
        Auth::login($user, $remember);

        session()->regenerate();
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        return redirect('login')->with(Auth::logout());
    }
}
