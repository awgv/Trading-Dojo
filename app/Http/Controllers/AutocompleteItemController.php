<?php namespace Dojo\Http\Controllers;

use Request;
use Dojo\Item;

class AutocompleteItemController extends Controller {


	/**
	 * Get search results.
	 * 
	 * @return String|Object
	 */
	public function getSearchResults()
	{
		$query = Request::input('name');

		if ( !$query && $query == '' ) {
			return '400';
		}


		$items = Item::where('name', 'like', '%' . $query . '%')
			->take(5)
			->orderBy('name', 'asc')
			->get();

		return $items;
	}


}