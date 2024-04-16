<?php

class WebsitesOverviewController extends \BaseController {

	public function index($website)
	{
		$this->website = $website;
		$data = array(
			'title' => $website->name.' - Overview',
			'website' => $website
		);

        $crawl = Crawl::last($website->id);
        if($crawl){
            $previous_crawl = Crawl::previousTo($website->id, $crawl->worked_on);

            $data['crawl'] = $crawl;

            if ($previous_crawl) {
				$data['issues'] = CrawlStats::stats($crawl);
				$changes = CrawlStats::diffByCrawls($previous_crawl, $crawl);
                $data['previous_crawl'] = $previous_crawl;
            } else {
                $changes = CrawlStats::diffByCrawls($previous_crawl, $crawl);
                $data['previous_crawl'] = NULL;
            }

            $data['changes_groups'] = ['0'=>[],'1'=>[],'2'=>[],'3'=>[],]; 
            foreach($changes as $change){
                $data['changes_groups'][$change->severety][] = $change;
            }

            $data['status_not_200'] = UrlStatus::getFromWebsiteExcept($website->id, $crawl->worked_on, 200);
            $data['status_not_200_total'] = UrlStatus::getCountFromWebsiteExcept($website->id, $crawl->worked_on, 200);

            //Not 200 Trend graph
            $data['not_200_graph'] = [
                [$crawl->worked_on, (int) $data['status_not_200_total'] ]
            ];
            //Paginated pages
            $data['paginated_pages_graph'] = [
                [$crawl->worked_on, (int) UrlStatus::getOverviewCountPagination($website->id, $previous_crawl->worked_on)]
            ];

            if($previous_crawl){
                //Not 200 Trend graph
                array_unshift(
                    $data['not_200_graph'],
                    [$previous_crawl->worked_on, (int)  UrlStatus::getCountFromWebsiteExcept($website->id, $previous_crawl->worked_on, 200) ]
                );
                //Paginated pages
                array_unshift(
                    $data['paginated_pages_graph'],
                    [$previous_crawl->worked_on, (int) UrlStatus::getOverviewCountPagination($website->id, $previous_crawl->worked_on)]
                );
            }

            //Depth Graph
            //Can this be done with just one query? Sure.
            $data['depth_params_failed_urls'] = UrlStatus::formatDepths(UrlStatus::getDepthCountByCodeGroup($website->id, $crawl->worked_on,'=',404));
            $data['depth_params_paginated_pages'] = UrlStatus::formatDepths(UrlStatus::getDepthCountByCodeGroup($website->id, $crawl->worked_on, NULL,NULL, $pag=TRUE));
            $data['depth_params_non_200_status'] = UrlStatus::formatDepths(UrlStatus::getDepthCountByCodeGroup($website->id, $crawl->worked_on,'!=',200));
            $data['depth_params_200_status'] = UrlStatus::formatDepths(UrlStatus::getDepthCountByCodeGroup($website->id, $crawl->worked_on,'=',200));

            //Robots
            $data['robots_index'] = (int) UrlStatus::getCountByFieldFromWebsite($website->id, $crawl->worked_on, 'robots_index' ) ;
            $data['robots_follow'] = (int) UrlStatus::getCountByFieldFromWebsite($website->id, $crawl->worked_on, 'robots_follow' ) ;

        } else {
            //TODO: we do not have information about your website yet!
            //Error message goes here
        }        
		
		return View::make('site.websites.overview')->with($data);
	}

}