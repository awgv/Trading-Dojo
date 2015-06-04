<?php namespace Dojo;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'offers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['seller_ign', 'platform', 'platform_slug', 'item_id', 'rank', 'price', 'code', 'commentary'];

	/**
	 * Defining relations.
	 */
	public function item()
	{
		return $this->belongsTo('Dojo\Item');
	}

	public function user()
	{
		return $this->belongsTo('Dojo\User');
	}

}
