<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('stripe_id');
			$table->string('name');
			$table->string('email');
			$table->string('address_line1');
			$table->string('address_line2');
			$table->string('address_city');
			$table->string('address_state');
			$table->string('address_zip');
			$table->string('address_country');
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
		Schema::drop('customers');
	}

}