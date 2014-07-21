<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function($table)
		{
			$table->increments('id');
			$table->string('name', 64)->unique();
			$table->string('tags'); // comma delimited
			$table->string('filename');
			$table->string('psd');
			$table->boolean('hasWallpaper');
			$table->boolean('hasBuyOptions');
			$table->boolean('hasPsd');
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
		Schema::drop('posts');
	}

}