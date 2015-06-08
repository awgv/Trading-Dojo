<?php namespace Dojo\Http\Controllers;

use Carbon\Carbon;
use Dojo\Offer;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Request;
use Session;

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
			$offers = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->with('Item', 'User')
			->orderBy('active', 'asc')
			->orderBy('created_at', 'desc')
			->paginate(20);


			$view = view('home')
				->with('user', $user)
				->with('offers', $offers);


			if ( !Request::cookie('source_code_notice') )
			{
				return Response::make($view)
					->withCookie(cookie()->forever('source_code_notice', 'unseen'));
			}
			else if ( Request::cookie('source_code_notice') === 'unseen' )
			{
				return Response::make($view)
					->withCookie(cookie()->forever('source_code_notice', 'seen'));
			}
			else
			{
				return Response::make($view);
			}
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