<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*
     * Login with Username or Email
     */
    public function username()
    {
        $identity = request()->identity;
        $field = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$field => $identity]);

        return $field;
    }

    /*
     * Check teacher approval after successful credentials.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->user_type === 'teacher' && $user->is_approved != 1) {
            auth()->logout();

            return redirect()->back()->withErrors([
                'identity' => 'Your teacher account is waiting for administrator approval.',
            ]);
        }
    }
}
