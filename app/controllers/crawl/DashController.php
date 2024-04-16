<?php
class DashController extends CrawlController  {

	public function index($crawl) {
		$website = Website::where('id', '=', $crawl->website_id)->first();
		$data = array('crawl' => $crawl);
		
		// Compare crawls if previous crawl is specified
		$prevCrawlId = Input::get('prevCrawlId', '');
		if ($prevCrawlId) {
			$prevCrawl = Crawl::where('id', '=', $prevCrawlId);
			$data['stats'] = $this->diff($crawl, $prevCrawl);
		} else {
			$data['stats'] = CrawlStats::stats($crawl);
		}

		$data1 = array_merge($data, array(
			'crawl' => $crawl,
			'crawls' => Crawl::byWebsite($website),
			'website' => $website,
			'prevCrawls' => Crawl::prevCrawls($crawl),
			'historic_urls' => Website::historicUrlsCount($website->id),
			'historic_duplicated' => Website::historicCount($website->id, 'duplicated'),
			'historic_non_200' => Website::historicNon200($website->id),
			'indexation_stats' => CrawlStats::where('typ', '=', 'indexation')
				->where('crawl_id', '=', $crawl->id)
				->select(['amount', 'description'])->get() ));
		
		return View::make('site.crawl.dashboard')
			->with(array_merge($this->getActiveMenu(), $data1));
	}
	
	/**
	 * Substract amount from `crawl` to `cmpCrawl`
	 * @param Crawl $crawl
	 * @param string $cmpCrawl
	 * @return $crawl-$cmpCrawl
	 */
	public function diffJson($crawl, $cmpCrawl, $typ) {
		$cmpCrawlObj = Crawl::findOrFail($cmpCrawl);
		if ($typ === 'all') {
			$data = ["stats" => $this->diff($crawl, $cmpCrawlObj, NULL, true)];
		}
		
		return Response::json($data);
	}
	
	public function dataTables($data) {
		return Datatables::of($data)
		->edit_column('url', '<a href="{{{ $url }}}">{{ $url }}</a>')
		->edit_column('crawled_on', '{{{ $created_at }}}')
		//->remove_column('total')
		->remove_column('id')
		->make();
	}

	public function generateFilename($crawl, $field) {
		$this->createWebsiteFolder($crawl);
		return "website_{$crawl->website_id}/crawl_{$crawl->id}_{$field}.csv";
	}

	/**
	 * Return URLs with $field <> 0 and not NULL
	 * 
	 * @param Crawl $crawl
	 * @param String $field
	 * @return Datatables
	 */
	public function nonZeroDataTables($crawl, $field) {
		if ($field === 'all-urls') {
			$data = UrlStatus::allUrls($crawl->id);
		} else if ($field === 'images') {
			$data = Image::allByCrawl($crawl->id);
		} else if ($field === 'no-alt-images') {
			$data = Image::noAltbyCrawl($crawl->id);
		} else {
			$data = UrlStatus::nonZero($crawl->id, $field);
		}

		// return CSV or DataTables JSON
		$format = Input::get('format', '');
		if ($format === 'csv') {
			$filename = $this->generateFilename($crawl, $field);
			return $this->csvDataTables((array)$data->get(), $filename);
		} else {
			return $this->dataTables($data);
		}
	}
}