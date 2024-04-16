<?php

define('TRASH', '<i class="glyphicon glyphicon-trash">');

class GwtDumpController extends \BaseController {

	public function index(GwtDump $gwtDump) {
		$data = array(
			'gwtDump' => $gwtDump,
			'website' => $gwtDump->website,
			'subtitle' => "GWT Sitemaps"
		);

		return $this->htmlOrCsv('sitemaps', $data, $gwtDump->sitemaps);
	}

	public function gwtErrors(GwtDump $gwtDump) {
		$data = [
			'gwtDump' => $gwtDump,
			'website' => $gwtDump->website,
			'errorCounts' => $gwtDump->error_counts,
			'errorCountsChart' => $gwtDump::error_counts_chart($gwtDump),
			'subtitle' => "GWT Crawl Errors"
		];
		
		return $this->htmlOrCsv('errors', $data, $gwtDump->errors);
	}

	function getActiveMenu() {
		$data = array();
		$data['sitemaps'] = '';
		$data['gwt_errors'] = '';

		if (str_contains(Request::url(), 'sitemaps')) {
			$data['sitemaps'] = 'active';
		} else if (str_contains(Request::url(), 'errors')) {
			$data['gwt_errors'] = 'active';
		}
		return $data;
	}

	public function htmlOrCsv($template, $data, $csvData) {
		$format = Input::get('format', '');
		if ($format === 'csv') {
			$filename = $this->generateFilename($template, $data['gwtDump']);
			return $this->pdoToCSV($csvData->toArray(), $filename);
		} else {
			return View::make("site.gwt.$template")
				->with(array_merge($this->getActiveMenu(), $data));
		}
	}

	public function pdoToCSV($data, $filename) {
		$filePath = public_path('download/'.$filename);
		$headerDisplayed = false;

		$fh = @fopen($filePath, 'w');
		foreach ($data as $row) {
			if (!$headerDisplayed) {
				fputcsv($fh, array_keys((array)$row));
				$headerDisplayed = true;
			}
			Log::info(print_r($row, TRUE));
			fputcsv($fh, (array)$row);
		}
		fclose($fh);

        $headers = array('Content-Type: text/csv',);
        return Response::download($filePath, basename($filePath), $headers);
	}

	public function generateFilename($name, $gwtDump) {
		$web_dir = "website_{$gwtDump->website_id}";
		String::title($web_dir);
		XFile::makeDownloadDir($web_dir);
		return "$web_dir/GWT_{$name}_{$gwtDump->id}.csv";
	}

	public function dumpsDataTables(Website $website) {
		// execute only if new month
		if (!GwtDump::already_dumped()) {
			$gwtd = new GoogleWebMasterToolsDump($website);
			$gwtd->init();
		}
		
		$dumps = GwtDump::byWebsite($website->id);
        return Datatables::of($dumps)
        	->edit_column('created_at', 
			'<a href="{{{ URL::route(\'gwt-sitemaps\', $id) }}}"><strong>{{ $created_at}}</strong></a>')
        	->edit_column('total_sitemaps', '<div class="centered">{{{ $total_sitemaps }}}</div>')
			->edit_column('total_errors', '<div class="centered">{{{ $total_errors }}}</div>')
        	->add_column('actions', '<div class="centered">
			<a href="#">'.TRASH.'</i></a></div>')
        	->remove_column('id')->make();
	}

	public function sitemapsDataTables($gwtDump) {
		$data = Sitemap::where('gwt_dump_id', '=', $gwtDump->id)
				->select(['path', 'type', 'errors', 'warnings', 'last_submitted']);
		return Datatables::of($data)
			->edit_column('path', '<a href="{{{ $path }}}">{{ $path }}</a>')
			->edit_column('type', '{{{ $type }}}')
			->edit_column('errors', '{{{ $errors }}}')
			->edit_column('warnings', '{{{ $warnings }}}')
			->edit_column('last_submitted', '{{{ $last_submitted }}}')
			->make();
	}

	public function errosDataTables($gwtDump) {
		$data = $gwtDump->gwt_errors->select(['page_url','category',
			'platform','last_crawled','first_detected','response_code']);

		return Datatables::of($data)
			->edit_column('path', '<a href="{{{ $path }}}">{{ $path }}</a>')
			->edit_column('type', '{{{ $type }}}')
			->edit_column('errors', '{{{ $errors }}}')
			->edit_column('warnings', '{{{ $warnings }}}')
			->edit_column('last_subtmitted', '{{{ $last_subtmitted }}}')
			->make();
	}
}
