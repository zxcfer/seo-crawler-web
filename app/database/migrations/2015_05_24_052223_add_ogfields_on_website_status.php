<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOgfieldsOnWebsiteStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('url_status', function($table)
		{
		    $table->text('og_title')->nullable();
		    $table->text('og_type')->nullable();
		    $table->text('og_url')->nullable();
		    $table->text('og_image')->nullable();
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
		    $table->dropColumn('og_title');
		    $table->dropColumn('og_type');
		    $table->dropColumn('og_url');
		    $table->dropColumn('og_image');
		});
	}

}
