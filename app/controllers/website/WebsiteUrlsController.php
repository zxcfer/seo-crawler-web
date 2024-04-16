<?php

class WebsitesUrlsController extends \BaseController {

	var $website;

    public function __construct()
    {
        parent::__construct();
        // $this->beforeFilter('@getWebsite', array('website_id' => $website_id));
    }

	public function index($website)
	{
		$this->website = $website;
		$data = array(
			'title' => 'Website Settings',
			'website' => $this->website
		);
		
		return View::make('site.websites.urls')->with($data);
	}
}
