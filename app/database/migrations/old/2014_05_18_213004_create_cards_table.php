<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cards', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('type')->default('standard');
			$table->longText('front_text');
			$table->longText('back_text');
			$table->timestamps();
			$table->time('finished_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cards');
	}

}
