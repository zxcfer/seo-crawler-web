<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the `Posts` table
		Schema::create('posts', function($table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned()->index();
			$table->string('title');
			$table->string('slug');
			$table->text('content');
			$table->string('meta_title');
			$table->string('meta_description');
			$table->string('meta_keywords');
			$table->string('image', 255);
			$table->string('website', 255);
			$table->string('email', 255);
			$table->string('contry', 255);
			$table->string('url', 255);
			$table->string('category', 2);
			$table->string('type', 2);
			$table->decimal('price', 20, 2);

			$table->string('status')->default('I');

			$table->integer('city_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->integer('region_id')->unsigned();
			$table->string('district', 255);

			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Delete the `Posts` table
		Schema::drop('posts');
	}

}
