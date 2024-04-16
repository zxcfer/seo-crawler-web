<?php

class ErrorsController extends CrawlController  {

	public function index($crawl) {
		return $this->table($crawl, 'on-site');
	}

	public function dataTables($data) {
		return Datatables::of($data)
			->edit_column('url', '<a href="{{{ $url }}}">{{ $url }}</a>')
			->edit_column('crawled_on', '{{{ $worked_on }}}')
			->remove_column('id')
			->make();
	}

	public function allUrlsDataTables($crawl) {
		return $this->dataTables(UrlStatus::allUrls($crawl->id));
	}

	public function generateFilename($crawl, $subtyp, $description) {
		$this->createWebsiteFolder($crawl);
		
		return "website_{$crawl->website_id}"
			."/crawl_{$crawl->id}_{$subtyp}_{$description}.csv";
	}

	public function onSiteDataTables($crawl, $subtyp, $description) {
		$data = UrlAlert::onSite($crawl->id, $subtyp, $description);
		
		$format = Input::get('format', '');
		if ($format === 'csv') {
			$filename = $this->generateFilename($crawl, $subtyp, $description);
			return $this->csvDataTables((array)$data->get(), $filename);
		} else {
			return $this->dataTables($data);
		}
	}	
}
