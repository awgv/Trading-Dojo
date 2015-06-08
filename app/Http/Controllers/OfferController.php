<?php namespace Dojo\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Request;
use Dojo\Http\Requests\StoreOfferRequest;
use Dojo\Item;
use Dojo\Offer;
use Dojo\User;

class OfferController extends Controller {


	/**
	 * Store a new offer for a guest.
	 *
	 * @return String
	 */
	public function guestStore(StoreOfferRequest $request)
	{
		$item = Item::where( 'name', Request::input('sell_item_name') )->first();

		if ($item)
		{
			$offer = new Offer;


			$offer->seller_ign = Request::input('sell_user_ign');
			$offer->user_id    = null;
			$offer->active     = null;


			$offer->platform      = Request::input('sell_item_platform');
			$offer->platform_slug = Str::slug(Request::input('sell_item_platform'));


			if ( Request::input('sell_item_rank') === '11' )
			{
				$offer->rank = null;
			}
			else
			{
				$offer->rank = Request::input('sell_item_rank');
			}

			$offer->price = Request::input('sell_item_price');


			$code = str_random(10);
			while ( Offer::where('code', $code)->first() )
			{
				$code = str_random(10);
			}


			$offer->code       = $code;
			$offer->commentary = Request::input('sell_item_commentary');
			$offer->item()->associate($item);
			$offer->save();

			return $code;
		}
		else
		{
			return 'Doesn\'t exist.';
		}
	}


	/**
	 * Store a new offer for an authenticated user.
	 *
	 * @return String
	 */
	public function authStore(StoreOfferRequest $request)
	{
		$item = Item::where( 'name', Request::input('sell_item_name') )->first();

		if ($item)
		{
			$offer = new Offer;


			$user = Auth::user();

			if ($user)
			{
				$offer->seller_ign = $user->name;
				$offer->user()->associate($user);
				$offer->active     = '1';
			}
			else
			{
				return 'Doesn\'t exist.';
			}


			$offer->platform      = Request::input('sell_item_platform');
			$offer->platform_slug = Str::slug(Request::input('sell_item_platform'));


			if ( Request::input('sell_item_rank') === '11' )
			{
				$offer->rank = null;
			}
			else
			{
				$offer->rank = Request::input('sell_item_rank');
			}

			$offer->price      = Request::input('sell_item_price');
			$offer->code       = null;
			$offer->commentary = Request::input('sell_item_commentary');
			$offer->item()->associate($item);
			$offer->save();

			return 'Created';
		}
		else
		{
			return 'Doesn\'t exist.';
		}
	}


	/**
	 * Remove an offer.
	 *
	 * @return String
	 */
	public function remove()
	{
		$user = Auth::user();

		if ($user && Request::input('sell_item_id'))
		{
			$offer = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->where('id', Request::input('sell_item_id'))
			->first();

			if ($offer)
			{
				$offer->delete();
				return 'Removed.';
			}
			else
			{
				return 'Doesn\'t exist.';
			}
		}
		else
		{
			$code  = Request::input('offer_code');
			$offer = Offer::where('code', $code)->first();
			if ($offer)
			{
				$offer->delete();
				return 'Removed.';
			}
			else
			{
				return 'Doesn\'t exist.';
			}
		}
	}


	/**
	 * Expire an offer.
	 *
	 * @return String
	 */
	public function expire(\Illuminate\Http\Request $request)
	{
		$user = Auth::user();

		if ($user && Request::input('sell_item_id'))
		{
			$offer = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->where('id', Request::input('sell_item_id'))
			->first();

			if ($offer)
			{
				$offer->active = '0';
				$offer->save();
				return 'Expired.';
			}
			else
			{
				return 'Doesn\'t exist.';
			}
		}
		else
		{
				return 'Doesn\'t exist.';
		}
	}


	/**
	 * Update an offer.
	 *
	 * @return String
	 */
	public function update(\Illuminate\Http\Request $request)
	{
		if ( Request::input('sell_item_price') || Request::input('sell_item_price') === '0' )
		{
			$this->validate($request, [
				'sell_item_price' => 'required|max:1000|min:1|numeric',
				'sell_item_id'    => 'required|numeric'
			]);


			$user = Auth::user();

			$offer = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->where('id', Request::input('sell_item_id'))
			->first();


			if ($offer)
			{
				$offer->price = Request::input('sell_item_price');
				$offer->save();

				return 'Saved.';
			}
			else
			{
				return 'Doesn\'t exist.';
			}
		}
		else
		{
			$this->validate($request, [
				'sell_item_commentary' => 'max:250',
				'sell_item_id'         => 'required|numeric'
			]);


			$user = Auth::user();

			$offer = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->where('id', Request::input('sell_item_id'))
			->first();


			if ($offer)
			{
				$offer->commentary = Request::input('sell_item_commentary');
				$offer->save();

				return 'Saved.';
			}
			else
			{
				return 'Doesn\'t exist.';
			}
		}
	}


	/**
	 * Renew an offer.
	 *
	 * @return String
	 */
	public function renew(\Illuminate\Http\Request $request)
	{
		$user = Auth::user();

		if ($user && Request::input('sell_item_id'))
		{
			$offer = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->where('id', Request::input('sell_item_id'))
			->first();


			if ($offer)
			{
				$date = new Carbon();

				$offer->active     = '1';
				$offer->created_at = $date;
				$offer->updated_at = $date;
				$offer->save();

				return 'Renewed.';
			}
			else
			{
				return 'Doesn\'t exist.';
			}
		}
		else
		{
				return 'Doesn\'t exist.';
		}
	}


	/**
	 * Renew all offers.
	 *
	 * @return String
	 */
	public function renewAll(\Illuminate\Http\Request $request)
	{
		$user = Auth::user();

		if ($user)
		{
			$offers = Offer::whereHas('User', function($query) use ($user)
			{
				$query->where('id', $user->id);
			})
			->where('active', '0')
			->get();

			if ($offers)
			{
				$date = new Carbon();

				foreach ($offers as $offer) {
					$offer->active     = '1';
					$offer->created_at = $date;
					$offer->updated_at = $date;
					$offer->save();
				}
			}
			else
			{
				return 'Doesn\'t exist.';
			}

			return 'Renewed.';
		}
		else
		{
				return 'Doesn\'t exist.';
		}
	}


	/**
	 * Get offers.
	 *
	 * @return Response
	 */
	public function get($platform, $item)
	{
		$offers = Offer::whereHas('Item', function($query) use ($item)
		{
			$query->where('slug', $item);
		})
		->where('platform_slug', $platform)
		->where( function($query) {
			$query
				->where('active', '1')
				->orWhere('active', null);
		})
		->with('Item')
		->orderBy('created_at', 'desc')
		->orderBy('price', 'asc')
		->paginate(50);


		if ($offers[0])
		{
			$user = Auth::user();

			if ($user)
			{
				return view('offers')
					->with('offers', $offers)
					->with('user', $user);
			}
			else
			{
				return view('offers')
					->with('offers', $offers);
			}
		}
		else
		{
			return view('nooffers');
		}
	}


	/**
	 * Get recent offers.
	 *
	 * @return Response
	 */
	public function recent($platform)
	{
		$oneDay = Carbon::now()->subDays(2);

		$offers = Offer::where('platform_slug', $platform)
		->where('created_at', '>=', $oneDay)
		->where( function($query) {
			$query
				->where('active', '1')
				->orWhere('active', null);
		})
		->orderBy('created_at', 'desc')
		->paginate(50);



		$user = Auth::user();

		if ($user)
		{
			return view('recent')
				->with('offers', $offers)
				->with('user', $user);
		}
		else
		{
			return view('recent')
				->with('offers', $offers);
		}
	}


	/**
	 * Method that's being called by a scheduler
	 * to remove everything older than 3 days.
	 *
	 * @return Void
	 */
	public function scheduledRemoval()
	{
		$threeDays = Carbon::now()->subDays(3);

		$offers = Offer::where('created_at', '<=', $threeDays)
		->where('user_id', null)
		->delete();

		$signedOffers = Offer::where('created_at', '<=', $threeDays)
		->where('user_id', '>', '0')
		->update(['active' => '0']);
	}


}