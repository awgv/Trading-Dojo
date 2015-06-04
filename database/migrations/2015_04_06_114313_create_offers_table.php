<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('seller_ign');
			$table->unsignedInteger('user_id')->nullable();
				$table->foreign('user_id')->references('id')->on('users');
			$table->string('platform');
			$table->string('platform_slug');
			$table->unsignedInteger('item_id');
				$table->foreign('item_id')->references('id')->on('items');
			$table->unsignedInteger('rank')->nullable();
			$table->unsignedInteger('price');
			$table->string('code')->nullable();
			$table->string('commentary')->nullable();
			$table->boolean('active')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('offers');
	}

}