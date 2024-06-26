<?php
	/**
	 *  PHP class for downloading CSV files from Google Webmaster Tools.
	 *
	 *  This class does NOT require the Zend gdata package be installed
	 *  in order to run.
	 *
	 *  Copyright 2012 eyecatchUp UG. All Rights Reserved.
	 *
	 *  Licensed under the Apache License, Version 2.0 (the "License");
	 *  you may not use this file except in compliance with the License.
	 *  You may obtain a copy of the License at
	 *
	 *     http://www.apache.org/licenses/LICENSE-2.0
	 *
	 *  Unless required by applicable law or agreed to in writing, software
	 *  distributed under the License is distributed on an "AS IS" BASIS,
	 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 *  See the License for the specific language governing permissions and
	 *  limitations under the License.
	 *
	 *  @author: Stephan Schmitz <eyecatchup@gmail.com>
	 *  @link:   https://code.google.com/p/php-webmaster-tools-downloads/
	 *  @link:   https://github.com/eyecatchup/php-webmaster-tools-downloads/
	 */

	 class GWTdata
	 {
		const HOST = "https://www.google.com";
		const SERVICEURI = "/webmasters/tools/";

		public $_language, $_tables, $_daterange, $_downloaded, $_skipped;
		private $_auth, $_logged_in;

		public function __construct()
		{
			$this->_auth = false;
			$this->_logged_in = false;
			$this->_language = "en";
			$this->_daterange = array("","");
			$this->_tables = array("TOP_PAGES", "TOP_QUERIES",
				"CRAWL_ERRORS", "CONTENT_ERRORS", "CONTENT_KEYWORDS",
				"INTERNAL_LINKS", "EXTERNAL_LINKS", "SOCIAL_ACTIVITY",
                "LATEST_BACKLINKS"
			);
			$this->_errTablesSort = array(0 => "http",
				1 => "not-found", 2 => "restricted-by-robotsTxt",
				3 => "unreachable", 4 => "timeout", 5 => "not-followed",
				"kAppErrorSoft-404s" => "soft404", "sitemap" => "in-sitemaps"
			);
			$this->_errTablesType = array(0 => "web-crawl-errors",
				1 => "mobile-wml-xhtml-errors", 2 => "mobile-chtml-errors",
				3 => "mobile-operator-errors", 4 => "news-crawl-errors"
			);
			$this->_downloaded = array();
			$this->_skipped = array();
		}

		/**
		 *  Sets content language.
		 *
		 *  @param $str     String   Valid ISO 639-1 language code, supported by Google.
		 */
			public function SetLanguage($str)
			{
				$this->_language = $str;
			}

		/**
		 *  Sets features that should be downloaded.
		 *
		 *  @param $arr     Array   Valid array values are:
		 *                          "TOP_PAGES", "TOP_QUERIES", "CRAWL_ERRORS", "CONTENT_ERRORS",
		 *                          "CONTENT_KEYWORDS", "INTERNAL_LINKS", "EXTERNAL_LINKS",
		 *                          "SOCIAL_ACTIVITY".
		 */
			public function SetTables($arr)
			{
				if(is_array($arr) && !empty($arr) && sizeof($arr) <= 2) {
					$valid = array("TOP_PAGES","TOP_QUERIES","CRAWL_ERRORS","CONTENT_ERRORS",
					  "CONTENT_KEYWORDS","INTERNAL_LINKS","EXTERNAL_LINKS","SOCIAL_ACTIVITY",
                      "LATEST_BACKLINKS");
					$this->_tables = array();
					for($i=0; $i < sizeof($arr); $i++) {
						if(in_array($arr[$i], $valid)) {
							array_push($this->_tables, $arr[$i]);
						} else { throw new Exception("Invalid argument given."); }
					}
				} else { throw new Exception("Invalid argument given."); }
			}

		/**
		 *  Sets daterange for download data.
		 *
		 *  @param $arr     Array   Array containing two ISO 8601 formatted date strings.
		 */
			public function SetDaterange($arr)
			{
				if(is_array($arr) && !empty($arr) && sizeof($arr) == 2) {
					if(self::IsISO8601($arr[0]) === true &&
					  self::IsISO8601($arr[1]) === true) {
						$this->_daterange = array(str_replace("-", "", $arr[0]),
						  str_replace("-", "", $arr[1]));
						return true;
					} else { throw new Exception("Invalid argument given."); }
				} else { throw new Exception("Invalid argument given."); }
			}

		/**
		 *  Returns array of downloaded filenames.
		 *
		 *  @return  Array   Array of filenames that have been written to disk.
		 */
			public function GetDownloadedFiles()
			{
				return $this->_downloaded;
			}

		/**
		 *  Returns array of downloaded filenames.
		 *
		 *  @return  Array   Array of filenames that have been written to disk.
		 */
			public function GetSkippedFiles()
			{
				return $this->_skipped;
			}

		/**
		 *  Checks if client has logged into their Google account yet.
		 *
		 *  @return Boolean  Returns true if logged in, or false if not.
		 */
			private function IsLoggedIn()
			{
				return $this->_logged_in;
			}

		/**
		 *  Attempts to log into the specified Google account.
		 *
		 *  @param $email  String   User's Google email address.
		 *  @param $pwd    String   Password for Google account.
		 *  @return Boolean  Returns true when Authentication was successful,
		 *                   else false.
		 */
			public function LogIn($email, $pwd)
			{
				$url = self::HOST . "/accounts/ClientLogin";
				$postRequest = array(
					'accountType' => 'HOSTED_OR_GOOGLE',
					'Email' => $email,
					'Passwd' => $pwd,
					'service' => "sitemaps",
					'source' => "Google-WMTdownloadscript-0.1"
				);
				
				// Before PHP version 5.2.0 and when the first char of $pass is an @ symbol, 
				// send data in CURLOPT_POSTFIELDS as urlencoded string.
				if ('@' === (string)$pwd[0] || version_compare(PHP_VERSION, '5.2.0') < 0) {
				    $postRequest = http_build_query($postRequest);
				}				
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postRequest);
				$output = curl_exec($ch);
				$info = curl_getinfo($ch);
				curl_close($ch);
				if($info['http_code'] == 200) {
					preg_match('/Auth=(.*)/', $output, $match);
					if(isset($match[1])) {
						$this->_auth = $match[1];
						$this->_logged_in = true;
						return true;
					} else { return false; }
				} else { return false; }
			}

		/**
		 *  Attempts authenticated GET Request.
		 *
		 *  @param $url    String   URL for the GET request.
		 *  @return Mixed  Curl result as String,
		 *                 or false (Boolean) when Authentication fails.
		 */
			public function GetData($url)
			{
				if(self::IsLoggedIn() === true) {
					$url = self::HOST . $url;
					$head = array("Authorization: GoogleLogin auth=".$this->_auth,
						"GData-Version: 2");
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($ch, CURLOPT_ENCODING, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
					$result = curl_exec($ch);
					$info = curl_getinfo($ch);
					curl_close($ch);
					return ($info['http_code']!=200) ? false : $result;
				} else { return false; }
			}

		/**
		 *  Gets all available sites from Google Webmaster Tools account.
		 *
		 *  @return Mixed  Array with all site URLs registered in GWT account,
		 *                 or false (Boolean) if request failed.
		 */
			public function GetSites()
			{
				if(self::IsLoggedIn() === true) {
					$feed = self::GetData(self::SERVICEURI."feeds/sites/");
					if($feed !== false) {
						$sites = array();
						$doc = new DOMDocument();
						$doc->loadXML($feed);
						foreach ($doc->getElementsByTagName('entry') as $node) {
							array_push($sites,
							  $node->getElementsByTagName('title')->item(0)->nodeValue);
						}
						return $sites;
					} else { return false; }
				} else { return false; }
			}

		/**
		 *  Gets the download links for an available site
		 *  from the Google Webmaster Tools account.
		 *
		 *  @param $url    String   Site URL registered in GWT.
		 *  @return Mixed  Array with keys TOP_PAGES and TOP_QUERIES,
		 *                 or false (Boolean) when Authentication fails.
		 */
			public function GetDownloadUrls($url)
			{
				if(self::IsLoggedIn() === true) {
					$_url = sprintf(self::SERVICEURI."downloads-list?hl=%s&siteUrl=%s",
					  $this->_language,
					  urlencode($url));
					$downloadList = self::GetData($_url);
					return json_decode($downloadList, true);
				} else { return false; }
			}

		/**
		 *  Downloads the file based on the given URL.
		 *
		 *  @param $site    String   Site URL available in GWT Account.
		 *  @param $savepath  String   Optional path to save CSV to (no trailing slash!).
		 */
			public function DownloadCSV($site, $savepath=".")
			{
				if(self::IsLoggedIn() === true) {
					echo "fer3";
					$downloadUrls = self::GetDownloadUrls($site);
					$filename = parse_url($site, PHP_URL_HOST) ."-". date("Ymd-His");
					$tables = $this->_tables;
					foreach($tables as $table) {
						if($table=="CRAWL_ERRORS") {
							echo "fer4";
							self::DownloadCSV_CrawlErrors($site, $savepath);
						}
//						elseif($table=="CONTENT_ERRORS") {
//							self::DownloadCSV_XTRA($site, $savepath,
//							  "html-suggestions", "\)", "CONTENT_ERRORS", "content-problems-dl");
//						}
						elseif($table=="CONTENT_KEYWORDS") {
							self::DownloadCSV_XTRA($site, $savepath,
							  "keywords", "\)", "CONTENT_KEYWORDS", "content-words-dl");
						}
						elseif($table=="INTERNAL_LINKS") {
							self::DownloadCSV_XTRA($site, $savepath,
							  "internal-links", "\)", "INTERNAL_LINKS", "internal-links-dl");
						}
						elseif($table=="EXTERNAL_LINKS") {
							self::DownloadCSV_XTRA($site, $savepath,
							  "external-links-domain", "\)", "EXTERNAL_LINKS", "external-links-domain-dl");
						}
//						elseif($table=="SOCIAL_ACTIVITY") {
//							self::DownloadCSV_XTRA($site, $savepath,
//							  "social-activity", "x26", "SOCIAL_ACTIVITY", "social-activity-dl");
//						}
                        elseif($table=="LATEST_BACKLINKS") {
                            self::DownloadCSV_XTRA($site, $savepath,
							  "external-links-domain", "\)", "LATEST_BACKLINKS", "backlinks-latest-dl");
                        }
						else {
							$finalName = "$savepath/$table-$filename.csv";
							$finalUrl = $downloadUrls[$table] ."&prop=ALL&db=%s&de=%s&more=true";
							$finalUrl = sprintf($finalUrl, $this->_daterange[0], $this->_daterange[1]);
							self::SaveData($finalUrl,$finalName);
						}
					}
				} else { return false; }
			}

		/**
		 *  Downloads "unofficial" downloads based on the given URL.
		 *
		 *  @param $site    String   Site URL available in GWT Account.
		 *  @param $savepath  String   Optional path to save CSV to (no trailing slash!).
		 */
			public function DownloadCSV_XTRA($site, $savepath=".", $tokenUri, $tokenDelimiter, $filenamePrefix, $dlUri)
			{
				if(self::IsLoggedIn() === true) {
					$uri = self::SERVICEURI . $tokenUri . "?hl=%s&siteUrl=%s";
					$_uri = sprintf($uri, $this->_language, $site);
					$token = self::GetToken($_uri, $tokenDelimiter, $dlUri);
					$filename = parse_url($site, PHP_URL_HOST) ."-". date("Ymd-His");
					$finalName = "$savepath/$filenamePrefix-$filename.csv";
					$url = self::SERVICEURI . $dlUri . "?hl=%s&siteUrl=%s&security_token=%s&prop=ALL&db=%s&de=%s&more=true";
					$_url = sprintf($url, $this->_language, $site, $token, $this->_daterange[0], $this->_daterange[1]);
					self::SaveData($_url,$finalName);
				} else { return false; }
			}

		/**
		 *  Downloads the Crawl Errors file based on the given URL.
		 *
		 *  @param $site    String   Site URL available in GWT Account.
		 *  @param $savepath  String   Optional: Path to save CSV to (no trailing slash!).
		 *  @param $separated Boolean  Optional: If true, the method saves separated CSV files
		 *                             for each error type. Default: Merge errors in one file.
		 */
			public function DownloadCSV_CrawlErrors($site, $savepath=".", $separated=false)
			{
				echo "extracting CRAWL_ERRORS\n";
				if(self::IsLoggedIn() === true) {
					$filename = parse_url($site, PHP_URL_HOST) ."-". date("Ymd-His");
					
					$uri = self::SERVICEURI."crawl-errors?hl=en&siteUrl=$site&authuser=0";
					echo "URL to get the Token: <$uri>\n";
					$token = self::GetToken($uri, "x22");

					$finalName = "$savepath/CRAWL_ERRORS-$filename.csv";
					$url = self::SERVICEURI."crawl-errors-new-dl?hl=%s&siteUrl=%s&security_token=%s";
					$_url = sprintf($url, $this->_language, $site, $token);
					echo "URL to download data: <$_url>\n";
					self::SaveData($_url,$finalName);

				} else { return false; }
			}

		/**
		 *  Saves data to a CSV file based on the given URL.
		 *
		 *  @param $finalUrl   String   CSV Download URI.
		 *  @param $finalName  String   Filepointer to save location.
		 */
			private function SaveData($finalUrl, $finalName)
			{
				$data = self::GetData($finalUrl);
				if(strlen($data) > 1 && file_put_contents($finalName, utf8_decode($data))) {
					array_push($this->_downloaded, realpath($finalName));
					return true;
				} else {
					array_push($this->_skipped, $finalName);
					return false;
				}
			}

		/**
		 *  Regular Expression to find the Security Token for a download file.
		 *
		 *  @param $uri        String   A Webmaster Tools Desktop Service URI.
		 *  @param $delimiter  String   Trailing delimiter for the regex.
		 *  @return  String    Returns a security token.
		 */
			private function GetToken($uri, $delimiter, $dlUri='')
			{
				$matches = array();
				$tmp = self::GetData($uri);
				file_put_contents('tmp.html', $tmp);
				preg_match_all("#$dlUri.*?46security_token(.*?)$delimiter#si", $tmp, $matches);
				var_dump($matches);
				return isset($matches[1][0]) ? substr($matches[1][0],3,-1) : '';
			}

		/**
		 *  Validates ISO 8601 date format.
		 *
		 *  @param $str      String   Valid ISO 8601 date string (eg. 2012-01-01).
		 *  @return  Boolean   Returns true if string has valid format, else false.
		 */
			private function IsISO8601($str)
			{
				$stamp = strtotime($str);
				return (is_numeric($stamp) && checkdate(date('m', $stamp),
					  date('d', $stamp), date('Y', $stamp))) ? true : false;
			}
	 }
?>
