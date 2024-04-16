<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeoSpiderTable extends Migration {

	public function up()
	{
		Schema::create('alert', function(Blueprint $table) {
		  $table->increments('id');
		  $table->text('description');
		  $table->integer('severety');
		});

		Schema::create('website', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('name', 100);
		  $table->string('url', 255);
		  $table->string('root_url', 255);
		  $table->text('description');
		  $table->integer('status')->default('1');
		  $table->timestamps();
		});

		Schema::create('website_status', function(Blueprint $table) {
		  $table->increments('id');
		  $table->integer('risk_level');
		  $table->dateTime('reported_at');
		  $table->integer('type')->default('1'); // (0 daily, 1 weekly)
		  $table->integer('website_id')->unsigned();
		  $table->foreign('website_id')->references('id')->on('website');
		  $table->timestamps();
		});

		Schema::create('url', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('url', 255);
		  $table->integer('type')->default('0'); // 0:normal, 1:vip
		  $table->date('reported_on');
		  $table->integer('website_id')->unsigned();
		  $table->foreign('website_id')->references('id')->on('website');
		  $table->timestamps();
		});

		Schema::create('url_alert', function(Blueprint $table) {
		  $table->increments('id');
		  $table->integer('url_id')->unsigned();
		  $table->foreign('url_id')->references('id')->on('url')->onDelete('cascade');
		  $table->date('reported_on');
		  $table->timestamps();
		});

		Schema::create('url_status', function(Blueprint $table) {
		  $table->increments('id');
		  $table->text('h1')->nullable();
		  $table->text('h2')->nullable();
		  $table->text('h3')->nullable();
		  $table->text('h4')->nullable();
		  $table->text('h5')->nullable();
		  $table->text('h6')->nullable();
		  $table->text('title')->nullable();
		  $table->text('description')->nullable();
		  $table->integer('url_id')->unsigned();
		  $table->foreign('url_id')->references('id')->on('url')->onDelete('cascade');
		  $table->date('reported_on');
		  $table->timestamps();
		});

		Schema::create('website_availability', function(Blueprint $table) {
		  $table->increments('id');
		  $table->integer('availability');
		  $table->dateTime('checked_at');
		  $table->integer('website_id')->unsigned();
		  $table->foreign('website_id')->references('id')->on('website')->onDelete('cascade');
		});

		Schema::create('website_availability_stats', function(Blueprint $table) {
		  $table->increments('id');
		  $table->decimal('average', 5, 2);
		  $table->integer('type')->default('0'); // -- 0:8hours, 1:24hours, 2:7days , 3:30days
		  $table->date('created_for');
		});

		Schema::create('website_user', function(Blueprint $table) {
		  $table->integer('user_role')->default('0'); //  0:normal, 1:admin
		  $table->integer('website_id')->unsigned();
		  $table->foreign('website_id')->references('id')->on('website')->onDelete('cascade');
		  $table->integer('user_id')->unsigned();
		  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	public function down()
	{
        Schema::drop('url_status');
        Schema::drop('url_alert');
        Schema::drop('url_alert');
        Schema::drop('url');
        Schema::drop('website_availability_stats');
        Schema::drop('website_availability');
        Schema::drop('website_user');
        Schema::drop('website');
        Schema::drop('alert');
	}

}
