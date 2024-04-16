<?php
class RobotsController extends \BaseController {

	public function index($crawl)
	{
		$website = Website::byCrawl($crawl->id)->first();
		$data = array(
			'title' => $website->name.' - '.$website->url,
			'website' => $website,
			'crawl' => $crawl
		);

		$crawl_comp = Crawl::previousTo($website->id, $crawl->worked_on);
		$stats = CrawlStats::stats($crawl);
		
		if ($crawl_comp) {
			$data['stats'] = CrawlStats::diffByCrawls($crawl, $crawl_comp);
		} else {
			$data['stats'] = $stats;
		}

		$data['crawls'] = Crawl::byWebsite($website->id);
		return View::make('site.crawl.dashboard')->with($data);
	}
}