<?php

class WebsitesAlertsController extends \BaseController {

	var $website;

    public function __construct()
    {
        parent::__construct();
    }

	public function index($website)
	{
		$this->website = $website;
		$alerts = Alert::all();
		$data = array(
			'title' => 'Website Settings',
			'website' => $this->website,
			'alerts' => $alerts,
			'severities' => Alert::$SEVERETIES
		);
		
		return View::make('site.websites.alerts')->with($data);
	}

    public function eventsByAlert($website, $alert){

    }

    public function eventsByAlertAjax(){
        
    }

}
