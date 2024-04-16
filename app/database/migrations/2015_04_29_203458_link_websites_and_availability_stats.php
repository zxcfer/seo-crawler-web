<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkWebsitesAndAvailabilityStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('website_availability_stats', function($table){
			$table->integer('website_id')->unsigned();
			$table->foreign('website_id')->references('id')->on('website')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('website_availability_stats', function($table)
		{
		    $table->dropColumn('website_id');
		});
	}

}
