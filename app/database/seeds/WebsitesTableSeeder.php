<?php

// Composer: "fzaninotto/faker": "v1.3.0"
//use Faker\Factory as Faker;

class WebsitesTableSeeder extends Seeder {

	public function run()
	{
	
		DB::table('website_availability_stats')->delete();
		DB::table('website_user')->delete();
		DB::table('website_availability')->delete();
		DB::table('website_status')->delete();
		//DB::table('website')->delete();

		//$faker = Faker::create();
		//$faker->addProvider(new \Faker\Provider\Base($faker));
		$today_date = date('Y-m-d H:i:s');

		//Query websites...

		$user = DB::table('users')->where('username', '=', 'user' )->first();
		$role = DB::table('roles')->where('name', '=', 'admin' )->first();

		$websites = DB::table('website')->get();
		$availability_ids = array();
		foreach($websites as $website){

			//Website availability
			$website_availability_id = DB::table('website_availability')->insert([
			    	'availability' => 1,
			    	'checked_at' => $today_date /*date('Y-m-d H:i:s', time() - $date_diff */,
			    	'website_id' => $website->id
			]);

			//User
			DB::table('website_user')->insert([
		    	'user_role' => $role->id,
		    	'user_id' => $user->id,
		    	'website_id' => $website->id
			]);

			//Website Availability Status
			//last 8 hours
			DB::table('website_availability_stats')->insert([
				'average' => mt_rand(85,100),
				'type' => 0,
				'created_for' => date('Y-m-d H:i:s'),
				'website_id' => $website->id
			]);
			//last 24 hours
			DB::table('website_availability_stats')->insert([
				'average' => mt_rand(85,100),
				'type' => 1,
				'created_for' => date('Y-m-d H:i:s'),
				'website_id' => $website->id
			]);
			//Last week
			DB::table('website_availability_stats')->insert([
				'average' => mt_rand(85,100),
				'type' => 2,
				'created_for' => date('Y-m-d H:i:s'),
				'website_id' => $website->id
			]);
			//Last Month
			DB::table('website_availability_stats')->insert([
				'average' => mt_rand(85,100),
				'type' => 3,
				'created_for' => date('Y-m-d H:i:s'),
				'website_id' => $website->id
			]);

			//Website Status
			//Last 24 hours
			DB::table('website_status')->insert([
				'risk_level' => mt_rand(0,3),
				'reported_at' => $today_date,
				'type' => 0,
				'website_id' => $website->id
			]);
			//Last Week
			DB::table('website_status')->insert([
				'risk_level' => mt_rand(0,3),
				'reported_at' => $today_date,
				'type' => 1,
				'website_id' => $website->id
			]);
		}
	}

}