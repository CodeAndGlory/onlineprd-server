<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Socialite;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string  $driver
     * @return Response
     */
    public function redirectToProvider($driver = 'google')
    {
        return Socialite::driver($driver)->with(["prompt" => "consent select_account"])->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @param $driver
     * @param  Request  $request
     * @return RedirectResponse|Response
     */
    public function handleProviderCallback($driver, Request $request)
    {
        try {
            $user = Socialite::driver($driver)->stateless()->user();
        } catch (Exception $e) {
            return redirect()->intended($this->redirectTo);
        }

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            $existingUser->avatar = $user->getAvatar();
            $existingUser->save();

            auth()->login($existingUser, true);
        } else {
            $newUser = new User;
            $newUser->provider_name = $driver;
            $newUser->provider_id = $user->getId();
            $newUser->email = $user->getEmail();
            $newUser->email_verified_at = now();
            $newUser->avatar = $user->getAvatar();
            $newUser->save();

//            auth()->login($newUser, true);
        }
        return $this->sendLoginResponse($request);
    }

    public function logout(Request $request)
    {
//        return response()->json([
//            'user' => auth()->user()->tokens,
//        ]);

        $httpClient = new Client();
        $googleToken = Socialite::driver('google')->user()->token;

//        $tokens = auth()->user()->tokens;
//        foreach ($tokens as $token) {
//            $token->revoke();
//        }

//        return response()->json(auth()->user());

        $response = $httpClient->get("https://oauth2.googleapis.com/revoke?token=$googleToken", [
            'headers' => ['Content-type' => 'application/x-www-form-urlencoded'],
        ]);

        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return $response->getBody();
//        return $this->loggedOut($request) ?: redirect('/');
    }
}
