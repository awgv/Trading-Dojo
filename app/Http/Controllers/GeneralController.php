<?php namespace Dojo\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Dojo\Offer;

class GeneralController extends Controller {


	/**
	 * Show Dojo's home page to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();

		if ( $user )
		{
			if ( !Session::has('source_code_notice') )
			{
				Session::put('source_code_notice', 'unseen');
			}
			else if ( Session::get('source_code_notice') === 'unseen' )
			{
				Session::set('source_code_notice', 'seen');
			}



			$offers = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->with('Item', 'User')
			->orderBy('active', 'asc')
			->orderBy('created_at', 'desc')
			->paginate(20);


			return view('home')
				->with('user', $user)
				->with('offers', $offers);
		}
		else
		{
			$twoDays = Carbon::now()->subDays(2);

			$offers = Offer::where('created_at', '>=', $twoDays)
			->where( function($query) {
				$query
					->where('active', '1')
					->orWhere('active', null);
			})
			->orderBy('created_at', 'desc')
			->paginate(50);


			return view('home')
				->with('offers', $offers);
		}
	}


}