<?php
require_once '../vendor/autoload.php';
//require_once 'Google/Client.php';
//require_once 'Google/Service/Webmasters.php';

// authorize: https://developers.google.com/apis-explorer/#p/
// create credentials: https://console.developers.google.com/project/poetic-planet-99705/apiui/credential
// webmaster API
// how to use: https://developers.google.com/api-client-library/php/auth/service-accounts?hl=es
// oauth: https://cloud.google.com/storage/docs/authentication

$gwt = new GoogleWebMasterFer();
$gwt->init('www.binacube.com');

class GoogleWebMasterFer {
	protected $gwt;
	var $platforms = ["smartphoneOnly", "web", "mobile"];
	var $categories = ["authPermissions", "notFollowed",
		"notFound", "other", "roboted", "serverError", "soft404", "manyToOneRedirect"];
	var $categories1 = ["authPermissions", "notFollowed",
		"notFound", "other", "roboted", "serverError", "soft404", "manyToOneRedirect"];
	var $today;
	public function __construct() {
		$client_email = '871026273322-si6b8dp5r6t78ulb7a9mi3uftfekj891@developer.gserviceaccount.com';
		$private_key = file_get_contents("D:\\wamp\\www\\laravel\\gwt\\My Project-51ade0436a70.p12");
		$scopes = array('https://www.googleapis.com/auth/webmasters.readonly',
						'https://www.googleapis.com/auth/webmasters');
		$credentials = new Google_Auth_AssertionCredentials($client_email, $scopes, $private_key);
		$client = new Google_Client();
		$client->setAssertionCredentials($credentials);
		if ($client->getAuth()->isAccessTokenExpired()) {
			$client->getAuth()->refreshTokenWithAssertion();
		}
		$this->gwt = new Google_Service_Webmasters($client);
		
	}

    public function init($siteUrl) {
		echo "\n==============\n";
		//$sites = $this->gwt->sites->listSites();
		$sitemaps = $this->gwt->sitemaps->listSitemaps($siteUrl);
		foreach ($sitemaps as $sitemap) {
			print_r(json_encode($sitemap->lastSubmitted));
			echo $sitemap->lastSubmitted."\n";
			echo $sitemap->path."\n";
			echo $sitemap->type."\n";
			// "lastSubmitted":"2015-07-08T10:40:14.257Z"
		}
		
//		echo "\n==Error Counts============\n";
//		$errorCounts = $this->gwt->urlcrawlerrorscounts->query($siteUrl);
//		foreach ($errorCounts->countPerTypes as $errorCount) {
//			
//			echo "== platform-".$errorCount->platform;
//			echo ":category-".$errorCount->category;
//			echo ":count-".$errorCount->entries[0]->count;
//			echo ":timestamp-".$errorCount->entries[0]->timestamp;
//		}

		echo "\n==Error Samples============\n";
		// get sitemaps and save
		foreach ($this->categories as $cat) {
			foreach ($this->platforms as $platform) {
				echo "cat: $cat, plat: $platform";
				if (!($cat === 'roboted' && ($platform === 'web' || $platform === 'mobile'))
						&& !($cat === 'soft404' && ($platform === 'mobile'))
						&& !($cat === 'manyToOneRedirect' && ($platform === 'web' || $platform === 'mobile'))
					) {
					$errors = $this->gwt->urlcrawlerrorssamples
						->listUrlcrawlerrorssamples($siteUrl, $cat, $platform);
					foreach ($errors as $error) {
						echo "\n== pageUrl".$error->pageUrl;
						echo ":last_crawled".$error->last_crawled;
						echo ":first_detected".$error->first_detected;
						echo ":responseCode".$error->responseCode;
					}
					// print_r(json_encode($errors->toSimpleObject()));
				} 
				echo "\n-----------------\n";
			}
		}

    }
}
//param string $category The crawl error category, for example
//488:    * 'authPermissions'
//489:    * @param string $platform The user agent type (platform) that made the request,
//490:    * for example 'web'
#$countErrors = $gwt->$urlcrawlerrorscounts->query($siteUrl);
//$sites = $sitesRepository->get('www.binacube.com');

//$sites = $sitesRepository->listSites();

//
//foreach($sites as $i => $site) {
//	echo "$i";
//	$googleWebmasterSite =  $site->siteUrl;
//}

//$sitemaps = $webmastersService->sitemaps->listSitemaps($googleWebmasterSite);
