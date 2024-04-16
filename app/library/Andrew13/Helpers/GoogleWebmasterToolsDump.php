<?php
//require_once 'Google/Client.php';
//require_once 'Google/Service/Webmasters.php';

// authorize: https://developers.google.com/apis-explorer/#p/
// create credentials: https://console.developers.google.com/project/poetic-planet-99705/apiui/credential
// webmaster API
// how to use: https://developers.google.com/api-client-library/php/auth/service-accounts?hl=es
// oauth: https://cloud.google.com/storage/docs/authentication

class GoogleWebMasterToolsDump {
	protected $gwt;
	public $website;
	var $gwt_dump;
	var $platforms = ["smartphoneOnly", "web", "mobile"];
	var $categories = ["authPermissions", "notFollowed","notFound", "other",
		"roboted", "serverError", "soft404", "manyToOneRedirect"];
		
	public function __construct($website) {
		$this->website = $website;
		if (strtoupper(getenv("LARAVEL_ENV")) === "DEV") {
			$client_email = '871026273322-si6b8dp5r6t78ulb7a9mi3uftfekj891@developer.gserviceaccount.com';
			$private_key_path = "D:\\wamp\\www\\laravel\\gwt\\My Project-51ade0436a70.p12";
		} else {
			$client_email = getenv("GWT_CLIENT_MAIL");
			$private_key_path = getenv("GWT_PRIVATE_KEY");
		}
		
		$private_key = file_get_contents($private_key_path);
		$scopes = array('https://www.googleapis.com/auth/webmasters.readonly',
						'https://www.googleapis.com/auth/webmasters');
		$credentials = new Google_Auth_AssertionCredentials($client_email, $scopes, $private_key);
		$client = new Google_Client();
		$client->setAssertionCredentials($credentials);
		if ($client->getAuth()->isAccessTokenExpired()) {
			$client->getAuth()->refreshTokenWithAssertion();
		}
		
		$this->gwt = new Google_Service_Webmasters($client);
		$this->gwt_dump = $this->createGwtDump();
	}

	public function createGwtDump() {
		return GwtDump::create([
			'site_url' => $this->website->root_url,
			'website_id' => $this->website->id,
		]);
	}
	
    public function init() {
		$sitemaps = $this->gwt->sitemaps->listSitemaps($this->website->root_url);
		foreach ($sitemaps as $sitemap) {
			Sitemap::create([
				'path' => $sitemap->path,
				'type' => $sitemap->type,
				'errors' => $sitemap->errors,
				'warnings' => $sitemap->warnings,
				'last_submitted' => $sitemap->lastSubmitted,
				'gwt_dump_id' => $this->gwt_dump->id
			]);
		}

		$errorCounts = $this->gwt->urlcrawlerrorscounts->query($this->website->root_url);
		foreach ($errorCounts->countPerTypes as $errorCount) {
			ErrorCount::create([
				'platform' => $errorCount->platform,
				'category' => $errorCount->category,
				'total' => $errorCount->entries[0]->count,
				'gwt_dump_id' => $this->gwt_dump->id
			]);
		}

		foreach ($this->categories as $cat) {
			foreach ($this->platforms as $platform) {
				$this->saveErrors($cat, $platform);
			}
		}
    }
	
	public function saveErrors($cat, $platform) {
		if (!($cat === 'roboted' && ($platform === 'web' || $platform === 'mobile'))
				&& !($cat === 'soft404' && ($platform === 'mobile'))
				&& !($cat === 'manyToOneRedirect' && ($platform === 'web' || $platform === 'mobile'))
			) {
			
			$errors = $this->gwt->urlcrawlerrorssamples
				->listUrlcrawlerrorssamples($this->website->root_url, $cat, $platform);
			
			foreach ($errors as $error) {
				GwtError::create([
					'category' => $cat,
					'platform' => $platform,
					'page_url' => $error->pageUrl,
					'last_crawled' => $error->lastCrawled,
					'first_detected' => $error->firstDetected,
					'response_code' => $error->responseCode,
					'gwt_dump_id' => $this->gwt_dump->id
				]);
			}
		}
	}
}