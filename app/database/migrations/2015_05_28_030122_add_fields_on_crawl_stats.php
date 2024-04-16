<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnCrawlStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('crawl_stats', function($table)
		{
			$table->integer('prop_id')->unsigned()->nullable();
			$table->string('prop_table', 25)->nullable();
			$table->integer('amount')->nullable();
			$table->string('description', 255)->nullable();
			$table->integer('crawl_id')->unsigned()->nullable();
//			$table->foreign('crawl_id')->references('id')->on('crawl')->onDelete('cascade');

			$table->dropColumn('property');
			$table->dropColumn('value');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('crawl_stats', function($table)
		{
		    $table->dropColumn('prop_id');
		    $table->dropColumn('prop_table');
		    $table->dropColumn('amount');
			$table->dropColumn('description');
			$table->dropColumn('crawl_id');
		});
	}

}

