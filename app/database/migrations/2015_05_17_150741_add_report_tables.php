<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportTables extends Migration {

	public function up()
	{
		Schema::create('crawl', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('notes', 50)->nullable();
            $table->date('worked_on');
			$table->integer('website_id')->unsigned();
			$table->foreign('website_id')->references('id')->on('website')->onDelete('cascade');
            $table->timestamps();
        });

		Schema::create('crawl_stats', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('property');
            $table->string('value');
            $table->timestamps();
        });
	}

	public function down()
	{
        Schema::drop('crawl');
        Schema::drop('crawl_stats');
	}

}
