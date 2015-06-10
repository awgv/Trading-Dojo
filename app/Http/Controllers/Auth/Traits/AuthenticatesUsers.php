<?php

namespace Dojo\Http\Controllers\Auth\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait AuthenticatesUsers
{
    use RedirectsUsers;

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'account_sign_in_email' => 'required|email', 'account_sign_in_password' => 'required',
        ]);


        $credentials = ['email' => $request->input('account_sign_in_email'), 'password' => $request->input('account_sign_in_password')];

        if (Auth::attempt($credentials, true)) {
            return 'Exists.';
        }


        return 'Doesn\'t exist.';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('account_sign_in_email', 'account_sign_in_password');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'These credentials do not match our records.';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }
}
