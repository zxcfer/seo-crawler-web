<?php
	include '../src/gwtdata.php';
	try {
		$email = "iwxfer@gmail.com";
		$passwd = "h,oVonfer45.";

		$gdata = new GWTdata();
		echo "fer";
		
		if($gdata->LogIn($email, $passwd) === true) {
			echo "fer2";
			$sites = $gdata->GetSites();
			foreach($sites as $site) {
				echo "fer3";
				$gdata->DownloadCSV($site, "./csv");
			}

			$files = $gdata->GetDownloadedFiles();
			echo "fer4";
			foreach($files as $file)
			{
				print "Saved $file<br>";
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
?>