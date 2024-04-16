<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnNewScope extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('website', function($table)
		{
			$table->integer('max_urls')->unsigned()->nullable();
			$table->integer('schedule')->default(1); // 1: weekly 2:bi 3:month
			$table->integer('crawl_day')->nullable(); // 1-7 or 1-30 week/month
			$table->time('crawl_hour')->nullable(); // 0-23:99
		});

		Schema::table('url', function($table)
		{
			$table->dropColumn('reported_on');
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
			$table->string('url_short',255)->nullable();
		});

		Schema::table('url_status', function($table)
		{
			$table->dropColumn('reported_on');
			
			$table->text('meta_key')->nullable();
			$table->integer('robots_nofollow')->nullable();
			$table->integer('robots_noindex')->nullable();
			$table->integer('robots_noarchive')->nullable();
			$table->integer('robots_nosnippet')->nullable();
			$table->integer('robots_noodp')->nullable();
			$table->integer('robots_noydir')->nullable();
			
			$table->integer('images')->nullable();
			$table->integer('no_alt_images')->nullable();
			
			$table->integer('facebook')->nullable(); // 0:ok, 1:complete, 2:incomplete
			$table->integer('twitter')->nullable(); // 0:ok, 1:complete, 2:incomplete
			
			$table->integer('struct_product')->nullable();
			$table->integer('struct_offer')->nullable();
			$table->integer('struct_aggreg')->nullable();
			$table->integer('struct_review')->nullable();
			$table->integer('struct_rating')->nullable();
				
			$table->integer('crawl_id')->unsigned()->nullable();;
			$table->foreign('crawl_id')->references('id')->on('crawl');
			//->onDelete('cascade')
			//$table->dropForeign('url_status_crawl_id_foreign');
		});

		Schema::table('crawl_stats', function($table)
		{
			$table->string('typ', 255)->nullable();
			$table->string('subtyp', 255)->nullable();
			$table->integer('severety')->nullable();
		});

		Schema::table('alert', function($table)
		{
			$table->string('typ')->nullable();
		});

		Schema::table('url_alert', function(Blueprint $table) {
			$table->dropColumn('reported_on');
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
						
			$table->integer('crawl_id')->unsigned()->nullable();
			$table->foreign('crawl_id')->references('id')->on('crawl');
		});
}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('website', function($table)
		{
		    $table->dropColumn('max_urls');
		    $table->dropColumn('schedule');
		    $table->dropColumn('crawl_day');
			$table->dropColumn('crawl_hour');
		});

		Schema::table('url', function($table)
		{
			$table->dropColumn('url_short');
		});
		
		Schema::table('url_status', function($table)
		{
		    $table->dropColumn('meta_key');
			$table->dropColumn('robots_nofollow');
			$table->dropColumn('robots_noindex');
			$table->dropColumn('robots_noarchive');
			$table->dropColumn('robots_nosnippet');
			$table->dropColumn('robots_noodp');
			$table->dropColumn('robots_noydir');
			$table->dropColumn('images');	
			$table->dropColumn('no_alt_images');
			$table->dropColumn('facebook');
			$table->dropColumn('twitter');
			$table->dropColumn('struct_product');
			$table->dropColumn('struct_offer');
			$table->dropColumn('struct_aggreg');
			$table->dropColumn('struct_review');
			$table->dropColumn('struct_rating');
			$table->dropForeign('url_status_crawl_id_foreign');
			$table->dropColumn('crawl_id');
		});

		Schema::table('crawl_stats', function($table)
		{
			$table->dropColumn('typ');
			$table->dropColumn('subtyp');
			$table->dropColumn('severety');
		});
	
		Schema::table('alert', function($table)
		{
			$table->dropColumn('typ');
		});
		
		Schema::table('url_alert', function(Blueprint $table) {
			$table->dropForeign('url_alert_crawl_id_foreign');
			$table->dropColumn('crawl_id');
		});
	}
}
