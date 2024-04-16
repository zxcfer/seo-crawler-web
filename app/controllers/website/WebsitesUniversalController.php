<?php

class WebsitesUniversalController extends \BaseController {


	public function index($website)
	{
		$this->website = $website;
		$data = array(
			'title' => 'Universal',
			'website' => $website
		);
		
		return View::make('site.websites.universal')->with($data);
	}
}