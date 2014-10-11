<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressCardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Addresses_Cards', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('Addresses_id')->unsigned()->index();
			$table->foreign('Addresses_id')->references('id')->on('Addresses')->onDelete('cascade');
			$table->integer('Cards_id')->unsigned()->index();
			$table->foreign('Cards_id')->references('id')->on('Cards')->onDelete('cascade');
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
		Schema::drop('Address_Card');
	}

}
