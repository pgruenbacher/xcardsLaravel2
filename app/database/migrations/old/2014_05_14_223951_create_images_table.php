<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('card_id')->unsigned()->index();
            $table->string('filename');
            $table->string('path');
            $table->integer('size');
            $table->string('extension');
            $table->string('mimetype');
            $table->integer('user_id')->unsigned()->index();
			$table->integer('card_id')->unsigned()->index();
            $table->integer('parent_id')->unsigned()->index(); // If this is a child file, it'll be referenced here.
            $table->softDeletes();
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
		Schema::drop('images');
	}

}
