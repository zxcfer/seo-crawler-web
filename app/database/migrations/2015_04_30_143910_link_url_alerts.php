<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkUrlAlerts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('url_alert', function($table){
	      $table->integer('alert_id')->unsigned();
	      $table->foreign('alert_id')->references('id')->on('alert')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('url_alert', function($table)
		{
		    $table->dropColumn('alert_id');
		});
	}

}
