<?php
include '../src/gwtdata.php';
try {
	$email = "iwxfer@gmail.com";
	$passwd = "ciVonfer45.";

	# Dates must be in valid ISO 8601 format. YYYY-MM-DD
	$daterange = array("2015-04-01", "2015-04-07");

	$gdata = new GWTdata();
	if($gdata->LogIn($email, $passwd) === true)
	{
		$sites = $gdata->GetSites();
		foreach($sites as $site)
		{
			$gdata->SetDaterange($daterange);
			$gdata->DownloadCSV($site);
		}
	}
} catch (Exception $e) {
	die($e->getMessage());
}