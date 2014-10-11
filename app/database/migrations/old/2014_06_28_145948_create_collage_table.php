<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCollageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collage', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('image1')->unsigned();
			$table->integer('image2')->unsigned();
			$table->integer('image3')->unsigned();
			$table->integer('image4')->unsigned();
			$table->integer('image5')->unsigned();
			$table->integer('image6')->unsigned();
			$table->string('orientation');
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
		Schema::drop('collage');
	}

}
