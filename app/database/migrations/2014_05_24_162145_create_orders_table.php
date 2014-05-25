<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('stripe_customer_id');
			$table->string('product');
			$table->string('name');
			$table->string('street');
			$table->string('city');
			$table->string('state');
			$table->integer('zip');
			$table->string('country');
			$table->string('email');
			$table->boolean('shipped');
			$table->boolean('received');
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
		Schema::drop('orders');
	}

}