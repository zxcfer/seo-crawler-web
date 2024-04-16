<?php

use Illuminate\Database\Migrations\Migration;

class AddFieldsSoftDeletes extends Migration {

	public function up()
	{
		Schema::table('website', function($table)
		{
			$table->softDeletes();
		});
		Schema::table('crawl', function($table)
		{
			$table->softDeletes();
		});

	}

	public function down()
	{
		Schema::table('website', function($table)
		{
			$table->dropColumn('deleted_at');
		});
		Schema::table('crawl', function($table)
		{
			$table->dropColumn('deleted_at');
		});
	}

}
