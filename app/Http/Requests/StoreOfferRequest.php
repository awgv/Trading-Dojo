<?php namespace Dojo\Http\Requests;

use Dojo\Http\Requests\Request;

class StoreOfferRequest extends Request {


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
			'sell_user_ign'            => 'required|max:255|alpha_num_dots',
			'sell_item_platform'       => 'required|max:8|alpha_num_spaces',
			'sell_item_name'           => 'required|max:255|alpha_num_spaces',
			'sell_item_rank'           => 'required|max:11|numeric',
			'sell_item_price'          => 'required|max:1000|min:1|numeric',
			'sell_item_commentary'     => 'max:250',
			'wax_name'                 => 'honeypot',
			'wax_time'                 => 'required|honeytime:3',
			'recaptcha_response_field' => 'recaptcha',
		];
	}


}
