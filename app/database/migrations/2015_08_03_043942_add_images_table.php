<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('src', 500);
		  $table->string('alt', 500)->nullable();
		  $table->integer('response_code')->nullable();
		  $table->integer('url_status_id')->unsigned();
		  $table->foreign('url_status_id')->references('id')->on('url_status')->onDelete('cascade');
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
