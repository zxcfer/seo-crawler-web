<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 255);
			$table->string('code', 20);
			$table->string('status', 1)->default('I');
			$table->string('business_type', 100);
			$table->text('description');
			$table->string('address', 255);
			$table->string('zip', 20);
			$table->string('email', 255);
			$table->string('phone', 20);
			$table->string('fax', 20);
			$table->integer('city_id');
			$table->integer('region_id');
			$table->string('country', 255);
			$table->string('url', 255);
			$table->integer('user_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companies');
	}

}
