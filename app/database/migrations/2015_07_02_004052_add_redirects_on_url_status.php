<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRedirectsOnUrlStatus extends Migration {

	public function up()
	{
		Schema::create('gwt_dump', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('website_id')->unsigned();
			$table->foreign('website_id')->references('id')->on('website')->onDelete('cascade');
			$table->string('site_url', 255);
			$table->timestamps();
		});
		
		Schema::create('gwt_sitemap', function(Blueprint $table) {
			$table->increments('id');
			$table->string('site_url', 255);
			$table->string('path', 255)->default("");
			$table->string('type', 20)->default("");
			$table->string('errors')->nullable();
			$table->string('warnings')->nullable();
			$table->dateTime('last_submitted')->nullable();
			$table->integer('gwt_dump_id')->unsigned();
			$table->foreign('gwt_dump_id')->references('id')->on('gwt_dump')->onDelete('cascade');
		});

		Schema::create('gwt_error_count', function(Blueprint $table) {
			$table->increments('id');
			$table->string('category', 20);
			$table->string('platform', 20)->default("");
			$table->integer('total')->default(0);
			$table->integer('gwt_dump_id')->unsigned();
			$table->foreign('gwt_dump_id')->references('id')->on('gwt_dump')->onDelete('cascade');
		});

		Schema::create('gwt_error_samples', function(Blueprint $table) {
			$table->increments('id');
			$table->string('page_url', 500)->nullable();
			$table->string('category', 20)->default("");
			$table->string('platform', 20)->default("");
			$table->dateTime('last_crawled')->nullable();
			$table->dateTime('first_detected')->nullable();
			$table->integer('response_code')->nullable();
			$table->integer('gwt_dump_id')->unsigned();
			$table->foreign('gwt_dump_id')->references('id')->on('gwt_dump')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('gwt_dump');
		Schema::drop('gwt_sitemap');
		Schema::drop('gwt_error_count');
		Schema::drop('gwt_error_samples');
	}

}
