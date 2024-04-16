<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regions', function(Blueprint $table) {
	    	$table->increments('id');
	    	$table->string('name', 255);
	    	$table->string('country');
	    });	

	    Schema::create('cities', function(Blueprint $table) {
	    	$table->increments('id');
	    	$table->string('name', 255);
	    	$table->integer('region_id');
	    });	

	    Schema::create('districts', function(Blueprint $table) {
	    	$table->increments('id');
	    	$table->string('name', 255);
	    	$table->integer('city_id');
	    });	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cities');
	}

}
