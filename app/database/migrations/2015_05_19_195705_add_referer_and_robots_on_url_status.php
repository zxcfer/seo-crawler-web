<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefererAndRobotsOnUrlStatus extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('url_status', function($table)
		{
		    $table->string('referer', 255)->nullable();
		    $table->string('redirect', 255)->nullable();
		    $table->integer('robots_index')->nullable();
		    $table->integer('robots_follow')->nullable(); //0 no ,1 yes
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	Schema::table('url_status', function($table)
		{
		    $table->dropColumn('referer');
		    $table->dropColumn('redirect');
		    $table->dropColumn('robots_index');
		    $table->dropColumn('robots_follow');
		});
	}

}