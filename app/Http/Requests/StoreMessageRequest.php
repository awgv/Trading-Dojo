<?php namespace Dojo\Http\Requests;

use Dojo\Http\Requests\Request;

class StoreMessageRequest extends Request {


	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'recipient.0' => 'required|max:255|alpha_num_dots',
			'subject'   => 'required|max:255',
			'message'   => 'required|max:500'
		];
	}


}