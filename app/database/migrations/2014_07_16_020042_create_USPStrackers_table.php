<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUSPStrackersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('USPStrackers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('card_id')->unsigned();
			$table->integer('address_id')->unsigned();
			$table->integer('USPS_id')->unique();
			$table->boolean('delivered');
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
		Schema::drop('USPStrackers');
	}

}
