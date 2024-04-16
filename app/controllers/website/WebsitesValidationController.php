<?php

class WebsitesValidationController extends \BaseController {

	public function index($website)
	{
		$this->website = $website;
		$data = array(
			'title' => 'Validation',
			'website' => $website
		);
		
        $crawl = Crawl::last($website->id);
        if($crawl){

            $groups = UrlStatus::getValidationGroups();
            $data['crawl'] = $crawl;

            $previous_crawl = Crawl::previousTo($website->id, $crawl->worked_on);
            if($previous_crawl){
                //20 queries... this can be completed using a big fat query
                foreach($groups as &$group){
                    foreach($group as &$item){
                        $item['amount'] = UrlStatus::getValidationInformationCount($website->id, $crawl->worked_on, $item['rules']);
                        $item['previous_amount'] = UrlStatus::getValidationInformationCount($website->id, $previous_crawl->worked_on, $item['rules']);
                    }
                }
                $data['previous_crawl'] = $previous_crawl;

            } else {
                foreach($groups as &$group){
                    foreach($group as &$item){
                        $item['amount'] = UrlStatus::getValidationInformationCount($website->id, $crawl->worked_on, $item['rules']);
                        $item['previous_amount'] = 0;
                    }
                }
                $data['previous_crawl'] = new DummyObject();
            }
            $data['groups'] = $groups;

        } else {
            //TODO: we do not have information about your website yet!
            //Error message goes here
        }

		return View::make('site.websites.validation')->with($data);
	}
}