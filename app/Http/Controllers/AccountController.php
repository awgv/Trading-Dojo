<?php namespace Dojo\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Dojo\Offer;
use Dojo\User;
use Request;
use Session;

class AccountController extends Controller {


	/**
	 * Set current status to online.
	 * 
	 * @return String
	 */
	public function statusOnline()
	{
		$user = Auth::user();

		if ($user)
		{
			$user->online_status = '1';
			$user->last_offline  = Carbon::now();
			$user->save();

			return 'Online.';
		}
		else
		{
			return 'Doesn\'t exist.';
		}
	}


	/**
	 * Set current status to offline.
	 * 
	 * @return String
	 */
	public function statusOffline()
	{
		$user = Auth::user();

		if ($user)
		{
			$user->online_status = '0';
			$user->save();

			return 'Offline.';
		}
		else
		{
			return 'Doesn\'t exist.';
		}
	}


	/**
	 * Get all seller's offers.
	 * 
	 * @return String
	 */
	public function seller($seller)
	{
		$user = User::where('name', $seller)->first();

		if ( $user )
		{
			$offers = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->where('active', '1')
			->with('Item')
			->orderBy('created_at', 'desc')
			->paginate(20);


			return view('seller')
				->with('user', $user)
				->with('offers', $offers);
		}
		else
		{
			return view('noseller');
		}
	}


	/**
	 * Switches online status off after 12 hours of being on.
	 * 
	 * @return Void
	 */
	public function scheduledStatusSwitcher()
	{
		$twelveHours = Carbon::now()->subHours(8);

		$users = User::where('online_status', '1')
			->where('last_offline', '<=', $twelveHours)
			->update(['online_status' => '0']);
	}


}