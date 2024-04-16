<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRootUrlToWebsite extends Migration {

	public function up()
	{
		Schema::table('url_status', function($table){
			$table->text('meta_desc')->nullable();
			$table->string('canonical', 255)->nullable();
			$table->string('pagination', 255)->nullable();
			$table->integer('url_status_code')->nullable();
		});
	}

	public function down()
	{
		Schema::table('url_status', function($table)
		{
		    $table->dropColumn('meta_desc');
		    $table->dropColumn('canonical');
		    $table->dropColumn('pagination');
		    $table->dropColumn('url_status_code');
		});
	}

}
