<?php

class WebsitesContentController extends \BaseController {


	public function index($website)
	{
		$this->website = $website;
		$data = array(
			'title' => 'Content',
			'website' => $website
		);

        $crawl = Crawl::last($website->id);
        if ($crawl) {

            $data['groups'] = Alert::getContentGroups();
            $data['crawl'] = $crawl;

            $the_ids = Alert::getContentIds();

            $content_now = UrlAlert::formatAlerts(
                UrlAlert::getContentInformation($website->id, $crawl->worked_on, $the_ids)
            );

            $previous_crawl = Crawl::previousTo($website->id, $crawl->worked_on);
            if($previous_crawl){

                $content_previous = UrlAlert::formatAlerts(
                    UrlAlert::getContentInformation($website->id, $previous_crawl->worked_on, $the_ids)
                );
                $data['previous_crawl'] = $previous_crawl;

            } else {
                $content_previous = [];
                foreach($the_ids as $the_id){
                    $content_previous[$the_id] = new DummyObject();
                }
                $data['previous_crawl'] = new DummyObject();
            }

            $data['content_now'] = $content_now;
            $data['content_previous'] = $content_previous;

        } else {
            //TODO: we do not have information about your website yet!
            //Error message goes here
        }
		
		return View::make('site.websites.content')->with($data);
	}


}