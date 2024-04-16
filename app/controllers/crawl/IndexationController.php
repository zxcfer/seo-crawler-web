<?php

class IndexationController extends CrawlController {

	public function index($crawl) {
		return $this->table($crawl, 'indexation');
	}

	public function dataTables($data) {
		return Datatables::of($data)
			->edit_column('url', '<a href="{{{ $url }}}">{{ $url }}</a>')
			->edit_column('crawled_on', '{{{ $created_at }}}')
			->remove_column('id')
			->make();
	}

	public function indexationData($crawl, $description) {
		switch ($description) {
		case "unique":
			$data = UrlStatus::unique($crawl->id);
			break;
		case "duplicated":
			$data = UrlStatus::duplicated($crawl->id);
			break;
		case "paginated":
			$data = UrlStatus::paginated($crawl->id);
			break;
		case "canonical":
			$data = UrlStatus::canonical($crawl->id);
			break;
		default: // 'all-urls'
			$data = UrlStatus::allUrls($crawl->id);
			break;
		}

		return $this->dataTablesOrCsv($data, $crawl, $description);
	}

	public function addedIndexationDataTable($description, $crawlId, $cmpCrawlId) {
		switch ($description) {
		case "unique":
			$data = UrlStatus::addedUniqueUrls($crawlId, $cmpCrawlId);
			break;
		case "duplicated":
			$data = UrlStatus::addedDuplicatedUrls($crawlId, $cmpCrawlId);
			break;
		case "paginated":
			$data = UrlStatus::addedPaginatedUrls($crawlId, $cmpCrawlId);
			break;
		case "canonical":
			$data = UrlStatus::addedCanonicalUrls($crawlId, $cmpCrawlId);
			break;
		default: // 'all-urls'
			$data = UrlStatus::allUrlsAdded($crawlId, $cmpCrawlId);
			break;
		}

		$filename = "{$description}-{$crawlId}-{$cmpCrawlId}.csv";
		return $this->addedDataTablesOrCsv($data, $filename);
	}

	public function dataTablesOrCsv($data, $crawl, $description) {
		$format = Input::get('format', '');
		if ($format === 'csv') {
			$filename = $this->generateFilename($crawl, $description);
			return $this->csvDataTables((array)$data->get(), $filename);
		} else {
			return $this->dataTables($data);
		}
	}
	
	public function addedDataTablesOrCsv($data, $filename) {
		$format = Input::get('format', '');
		if ($format === 'csv') {
			return $this->csvDataTables((array)$data->get(), $filename);
		} else {
			return $this->dataTables($data);
		}
	}
	
	public function generateFilename($crawl, $description) {
		$this->createWebsiteFolder($crawl->website_id);
		
		return "website_{$crawl->website_id}"
			."/crawl_{$crawl->id}_indexation_{$description}.csv";
	}
	

}
