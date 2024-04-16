<?php

class WebsitesActivityLogController extends \BaseController {

	public function index()
	{

		$data = array(
			'title' => 'Overview'			
		);
		
		return View::make('site.overview.index')->with($data);
	}
}