<?php

class CrawlController extends \BaseController {

	public static $TRASH1 = '<span class="glyphicon glyphicon-trash"></span>';

	public function table($crawl, $typ) {
		$data = $this->getBasicData($crawl, $typ);
		$data['historicStats'] = CrawlStats::historicStats($crawl, $typ);

		$cmpCrawlId = Input::get('compCrawlId');
		$cmpCrawl = $this->getCrawlToCompareWith($cmpCrawlId, $crawl);

		if ($cmpCrawl === NULL) {
			$data['stats'] = CrawlStats::getStats($crawl, $typ);
		} else {
			$data['stats'] = $this->diff($crawl, $cmpCrawl, $typ);
		}

		$data['cmpCrawl'] = $cmpCrawl;

		$template = String::urlize($typ);
		return View::make("site.crawl.$template")
			->with(array_merge($this->getActiveMenu(), $data));
	}

	public function getBasicData($crawl, $typ) {
		return array(
			'subtitle' => String::title($typ),
			'crawl' => $crawl,
			'website' => Website::where('id', '=', $crawl->website_id)->first(),
			'prevCrawls' => Crawl::prevCrawls($crawl),
		);
	}

	function getActiveMenu() {
		$data = array();
		$data['dashboard'] = '';
		$data['indexation'] = '';
		$data['on_site'] = '';
		$data['response_codes'] = '';

		if (str_contains(Request::url(), 'dashboard')) {
			$data['dashboard'] = 'active';
		} else if (str_contains(Request::url(), 'indexation')) {
			$data['indexation'] = 'active';
		} else if (str_contains(Request::url(), 'on-site')) {
			$data['on_site'] = 'active';
		} else if (str_contains(Request::url(), 'response-codes')) {
			$data['response_codes'] = 'active';
		}

		return $data;
	}

	public function csvDataTables($data, $filename) {
		$filePath = public_path('download/'.$filename);
		$headerDisplayed = false;

		$fh = @fopen($filePath, 'w');
		foreach ($data as $row) {
			if (!$headerDisplayed) {
				fputcsv($fh, array_keys((array)$row));
				$headerDisplayed = true;
			}
			fputcsv($fh, (array)$row);
		}
		fclose($fh);

        $headers = array('Content-Type: text/csv',);
        return Response::download($filePath, basename($filePath), $headers);
	}

	public function createWebsiteFolder($website_id) {
		$website_folder = 'download/website_'.$website_id;

		if (!file_exists($website_folder)) {
			mkdir($website_folder, 0777, true);
		}
	}

	public function diff($recent_crawl, $old_crawl, $typ=NULL, $replace_amount=false)
	{
		$recent_stats = CrawlStats::stats($recent_crawl, $typ);
		$old_stats = CrawlStats::stats($old_crawl, $typ);

		$diff = new \Illuminate\Database\Eloquent\Collection;

		// add stats that exists on both `old` and `recent`
        foreach ($old_stats as $stat) {
			$recent = $stat->in($recent_stats);
			$stat = $this->setIncreaseDecrease($recent, $stat, $replace_amount);
			$diff->add($stat);
		}

		// add stats that not exists in old
		foreach ($recent_stats as $stat) {
			if (!$stat->in($old_stats)) {
				$stat->increase = 0;
				$stat->decrease = 0;
				$diff->add($stat);
			}
		}
        return $diff;
	}

	public function setIncreaseDecrease($stat, $cmpStat, $replace_amount) {
		if ($stat === false) {
			$cmpStat->decrease = "NO DATA";
			$cmpStat->increase = "NO DATA";
			return $cmpStat;
		}

		$stat->amount = $replace_amount ? $stat->amount-$cmpStat->amount : $stat->amount;

		$stat1 = $stat->crawl_id;
		$stat2 = $cmpStat->crawl_id;

		if ($stat->typ == 'indexation') {
			$stat = $this->setIncreaseDecreaseIndexation($stat, $stat1, $stat2);
		} else if ($stat->typ == 'on-site') {
			$stat = $this->setIncreaseDecreaseOnSite($stat, $cmpStat);
		} else if ($stat->typ == 'Response Codes') {
			$code = explode(" ", $stat->description)[0];
			$stat->increase = UrlStatus::addedResponseCodeUrls($stat1, $stat2, $code)->count();
			$stat->decrease = UrlStatus::addedResponseCodeUrls($stat2, $stat1, $code)->count();
		} else {
			//$stat->increase = UrlStatus::addedNonZeroFieldUrls($stat1, $stat2, $stat->description)->count();
			//$stat->decrease = UrlStatus::addedNonZeroFieldUrls($stat2, $stat1, $stat->description)->count();
		}

		return $stat;
	}

	public function getCrawlToCompareWith($compCrawlId, $crawl) {
		if ($compCrawlId) {
			return Crawl::filter('id', '=', $compCrawlId)->first();
		} else {
			return Crawl::previous($crawl);
		}
	}

	public function setIncreaseDecreaseIndexation($stat, $stat1, $stat2) {
		if ($stat->description == 'unique') {
			$stat->increase = UrlStatus::addedUniqueUrls($stat1, $stat2, $action='count')[0]->total;
			$stat->decrease = UrlStatus::addedUniqueUrls($stat2, $stat1, $action='count')[0]->total;
		} else if ($stat->description == 'duplicated') {
			$stat->increase = UrlStatus::addedDuplicatedUrls($stat1, $stat2, $action='count')[0]->total;
			$stat->decrease = UrlStatus::addedDuplicatedUrls($stat2, $stat1, $action='count')[0]->total;
		} else if ($stat->description == 'paginated') {
			$stat->increase = UrlStatus::addedPaginatedUrls($stat1, $stat2)->count();
			$stat->decrease = UrlStatus::addedPaginatedUrls($stat2, $stat1)->count();
		} else if ($stat->description == 'canonical') {
			$stat->increase = UrlStatus::addedCanonicalUrls($stat1, $stat2)->count();
			$stat->decrease = UrlStatus::addedCanonicalUrls($stat2, $stat1)->count();
		} else {
			$stat->increase = UrlStatus::allUrlsAdded($stat1, $stat2)->count();
			$stat->decrease = UrlStatus::allUrlsAdded($stat2, $stat1)->count();	
		}
		return $stat;
	}

	public function setIncreaseDecreaseOnSite($stat, $cmpStat) {
		if ($stat->typ == 'on-site') {
			$stat->increase = UrlAlert::addedOnSiteUrls(
				$stat->crawl_id, 
				$cmpStat->crawl_id, 
				$stat->subtyp, 
				$stat->description )->count();
			
			$stat->decrease = UrlAlert::addedOnSiteUrls(
				$cmpStat->crawl_id, 
				$stat->crawl_id, 
				$stat->subtyp, 
				$stat->description)->count();
		}
		return $stat;
	}

	/**
	 * Return the all the crawls of a website
	 * 
	 * @param Website $website
	 * @return Datatables
	 */
    public function crawlsData(Website $website){
        $crawls = Crawl::byWebsite($website);
        return Datatables::of($crawls)
            ->edit_column('worked_on', 
			'<a href="{{{ URL::to(\'crawl/dashboard/\'.$id ) }}}"><strong>{{{$worked_on}}}</strong></a>')
            ->edit_column('depth', '<div class="centered ">{{ $depth }}</div>')
            ->edit_column('urls', '<div class="centered ">{{ $urls }}</div>')
            ->add_column('actions', '
			<div class="centered">
			<a href="#" class="delete" id="crawl__{{{$id}}}__{{{$worked_on}}}">'.self::$TRASH1.'</a>
			</div>')
            ->remove_column('id')
			->remove_column('notes')
			->make();
    }
	
	public function confirmDelete($crawl) {
        try {
            $crawl->delete();
        } catch (Exception $e){
            return Response::json(array('deleted' => 'false'));
        }
		
        return Response::json(array('deleted' => 'true'));
	}
}
