<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteJoinIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('website_user', function($table){
			$table->index(array('website_id','user_id'));
		});
		/*
		Schema::table('website', function($table){
			$table->index(array('id','status'));
		});
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('website_user', function($table){
			$table->dropIndex('website_user_website_id_user_id_index');
		});
		/*
		Schema::table('website', function($table){
			$table->dropIndex('website_id_status_index');
		});
		*/
	}

}
