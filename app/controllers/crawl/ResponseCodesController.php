<?php
class ResponseCodesController extends CrawlController  {

	public function index($crawl) {
		return $this->table($crawl, 'Response Codes', 'response-codes');
	}

	public function dataTables($data) {
		return Datatables::of($data)
			->edit_column('url', '<a href="{{{ $url }}}">{{ $url }}</a>')
			->edit_column('crawled_on', '{{{ $created_at }}}')
			->remove_column('id')
			->make();
	}

	public function responseCodesDataTables($crawl, $code) {
		$data = UrlStatus::responseCodeUrls($crawl->id, $code);
		
		$format = Input::get('format', '');
		if ($format === 'csv') {
			$filename = $this->generateFilename($crawl, $code);
			return $this->csvDataTables((array)$data->get(), $filename);
		} else {
			return $this->dataTables($data);
		}
	}
	
	public function generateFilename($crawl, $code) {
		$this->createWebsiteFolder($crawl);
		
		return "website_{$crawl->website_id}"
			."/crawl_{$crawl->id}_response-code_{$code}.csv";
	}
	
	public function addedResponseCodesDataTables($crawlId, $cmpCrawlId, $code) {
		$data = UrlStatus::addedResponseCodeUrls($crawlId, $cmpCrawlId, $code);
		$filename = "http-code-{$code}-{$crawlId}-{$cmpCrawlId}.csv";
		
		$format = Input::get('format', '');
		if ($format === 'csv') {
			return $this->csvDataTables((array)$data->get(), $filename);
		} else {
			return $this->dataTables($data);
		}
	}

}
