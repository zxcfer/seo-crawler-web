<?php
	include '../src/gwtdata.php';
	try {
		$email = "iwxfer@gmail.com";
		$passwd = "h,oVonfer45.";

		# If hardcoded, don't forget trailing slash!
		$website = "http://www.binacube.com/";

		# Valid values are "TOP_PAGES", "TOP_QUERIES", "CRAWL_ERRORS",
		# "CONTENT_ERRORS", "CONTENT_KEYWORDS", "INTERNAL_LINKS",
		# "EXTERNAL_LINKS" and "SOCIAL_ACTIVITY".
		$tables = array("CRAWL_ERRORS");

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $passwd) === true)
		{
			$gdata->SetTables($tables);
			$gdata->DownloadCSV($website);
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
?>