<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterForeignsOnDeleteCrawlId extends Migration {

	public function up()
	{
		Schema::table('crawl_stats', function($table)
		{
			DB::statement('ALTER TABLE `crawl_stats` MODIFY `crawl_id` INT UNSIGNED NULL;');
			
			// `crawl_stats`.`crawl_id` should match `crawl.id`
			// $table->dropForeign('crawl_stats_crawl_id_foreign');
			$table->foreign('crawl_id')->references('id')->on('crawl')->onDelete('cascade');
		});
		
		Schema::table('url_status', function($table)
		{
			$table->dropForeign('url_status_crawl_id_foreign');
			$table->foreign('crawl_id')->references('id')->on('crawl')->onDelete('cascade');
		});

		Schema::table('url_alert', function($table)
		{
			$table->dropForeign('url_alert_crawl_id_foreign');
			$table->foreign('crawl_id')->references('id')->on('crawl')->onDelete('cascade');
		});
	}

	public function down()
	{
		// $table->dropForeign('crawl_stats_crawl_id_foreign');
	}

}
