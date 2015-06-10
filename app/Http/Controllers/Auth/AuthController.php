<?php namespace Dojo\Http\Controllers\Auth;

use Dojo\User;
use Validator;
use Dojo\Http\Controllers\Controller;
use Dojo\Http\Controllers\Auth\Traits\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'account_ign'      => 'required|alpha_num_dots|max:255|unique:users,name',
			'account_email'    => 'required|email|max:255|unique:users,email',
			'account_password' => 'required|confirmed|min:6'
		]);
	}


	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name'     => $data['account_ign'],
			'email'    => $data['account_email'],
			'password' => bcrypt($data['account_password']),
		]);
	}

}