<?php namespace Dojo\Services;

use Dojo\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
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
	public function create(array $data)
	{
		return User::create([
			'name'     => $data['account_ign'],
			'email'    => $data['account_email'],
			'password' => bcrypt($data['account_password']),
		]);
	}

}
