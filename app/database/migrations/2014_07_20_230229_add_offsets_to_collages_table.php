<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOffsetsToCollagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('collages', function(Blueprint $table)
		{
			$table->integer('image1offsetx');
			$table->integer('image1offsety');
			$table->integer('image2offsetx');
			$table->integer('image2offsety');
			$table->integer('image3offsetx');
			$table->integer('image3offsety');
			$table->integer('image4offsetx');
			$table->integer('image4offsety');
			$table->integer('image5offsetx');
			$table->integer('image5offsety');
			$table->integer('image6offsetx');
			$table->integer('image6offsety');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('collages', function(Blueprint $table)
		{
			$table->dropColumn('image1offsetx');
			$table->dropColumn('image1offsety');
		});
	}

}
