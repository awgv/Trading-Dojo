<?php namespace Dojo;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'items';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'type'];

	/**
	 * Defining relations.
	 */
	public function item()
	{
		return $this->hasMany('Dojo\Offer');
	}

}
