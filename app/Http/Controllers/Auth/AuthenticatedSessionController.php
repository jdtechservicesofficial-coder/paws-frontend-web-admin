<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Trait\AuthTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    use AuthTrait;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $user = User::where('email', request('email'))->first();
        if(!$user){
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Restrict customer accounts from logging into the Admin Portal
        if ($user->user_type === 'user' || $user->hasRole('user')) {
            return back()->withErrors([
                'email' => 'Access denied. This portal is for administrative and staff accounts only. Please use the mobile application to access your customer account.',
            ])->onlyInput('email');
        }

        $isActive = $this->checkService($request);
        $usertype = $user->user_type;

        if($usertype == "vet" || $usertype == "groomer" || $usertype == "walker" || $usertype == "boarder" || $usertype == "trainer" || $usertype == "day_taker" || $usertype == "pet_store"){

            if($user->email_verified_at == null){
                return back()->withErrors([
                    'custom_message' =>  __('messages.account_not_verify'),
                ]);
            }
        }

        if($isActive==1){

            $isLogin = $this->loginTrait($request);

            if ($isLogin) {
                $request->session()->regenerate();

                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                Artisan::call('config:cache');
                Artisan::call('route:clear');
    
                return redirect('/');
            }
    
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');

        }else{

            $message = 'This service is inactive. Please contact your Administration.';
            return back()->withErrors([
                'custom_message' => $message,
            ]);

        } 
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
