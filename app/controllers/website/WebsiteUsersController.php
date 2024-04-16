<?php

class WebsitesUsersController extends \BaseController {


	public function index($website)
	{
		$this->website = $website;
		$data = array(
			'title' => 'Manage Users',
			'website' => $website
		);
		
		return View::make('site.websites.users')->with($data);
	}
}