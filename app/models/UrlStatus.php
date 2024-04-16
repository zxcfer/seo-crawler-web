<?php
class UrlStatus extends \Eloquent {

    protected $table = "url_status";
	public static $create_update = " NOW() AS created_at, NOW() AS updated_at ";
	public static $fields = ['url.url', 
							 'url_status.id', 
							 'url_status.created_at'];
	
    // Add your validation rules here
    public static $rules = [/* 'title' => 'required'*/];

	public static function allUrls($crawl_id) {
		return DB::table('url_status')
			->join('url', 'url.id', '=', 'url_status.url_id')
        	->join('crawl', 'crawl.id', '=', 'url_status.crawl_id')
        	->select(UrlStatus::$fields)
            ->where('url_status.crawl_id', '=', $crawl_id);
	}

	// Return list of unique URLs
	public static function unique($crawl_id) {
		return DB::table('url_status')
			->join('url', 'url.id', '=', 'url_status.url_id')
        	->join('crawl', 'crawl.id', '=', 'url_status.crawl_id')
        	->select(['url.url_short AS url', 
					  'url_status.id',
					  'url_status.created_at'])
            ->where('url_status.crawl_id', '=', $crawl_id)
			->groupBy('title', 'meta_desc', 'url_short');
	}
	
	public static function duplicated($crawl_id) {
		return UrlStatus::allUrls($crawl_id)
			->whereNotIn('url.url', function ($sql) use($crawl_id) {
				$sql->select('url.url_short')->from('url_status')
				->join('url', 'url.id', '=', 'url_status.url_id')
				->join('crawl', 'crawl.id', '=', 'url_status.crawl_id')
				->where('url_status.crawl_id', '=', $crawl_id)
				->groupBy('title', 'meta_desc', 'url_short');
			})
			->select(UrlStatus::$fields);
    }
	
	public static function paginated($crawl_id) {
		return UrlStatus::allUrls($crawl_id)
			->where('url_status.pagination', '<>', '')
			->whereNotNull('url_status.pagination');
        	//->orderBy('url_status.created_at', 'desc');
	}

	public static function canonical($crawl_id) {
		return UrlStatus::allUrls($crawl_id)
			->where('url_status.canonical', '<>', '')
			->whereNotNull('url_status.canonical');
	}
	
	public static function nonZero($crawl_id, $field) {
		$_field = String::quoteIdentifier($field);
		return UrlStatus::allUrls($crawl_id)
			->where("url_status.$_field", '<>', 0)
			->whereNotNull("url_status.$_field");
        	//->orderBy('url_status.created_at', 'desc');
	}
	
	public static function responseCodeUrls($crawl_id, $code) {
		return UrlStatus::allUrls($crawl_id)
			->where('url_status.url_status_code', '=', $code);
	}

	public static function joinAndFilter($sql, $cmp_crawl_id){
		return $sql->select('url.url')->from('url_status')
			->join('url', 'url.id', '=', 'url_status.url_id')
			->join('crawl', 'crawl.id', '=', 'url_status.crawl_id')
			->where('url_status.crawl_id', '=', $cmp_crawl_id);
	}

	public static function allUrlsAdded($crawl_id, $cmp_crawl_id) {
		return UrlStatus::allUrls($crawl_id)
			->whereNotIn('url.url', function ($sql) use($cmp_crawl_id) {
				UrlStatus::joinAndFilter($sql, $cmp_crawl_id);
			});
	}
	
	public static function getFields($action) {
		if ($action == 'count') {
			return "count(*) AS total ";
		} else {
			return "title, meta_desc, url_short AS url";
		}
	}
	
	public static function addedUniqueUrls($crawl_id, $cmp_crawl_id, $action="") {
		$fields = UrlStatus::getFields($action);
		$where = "crawl_id = ? GROUP BY title, meta_desc, url_short";
		$fromJoin = "FROM url_status us JOIN url u ON u.id = us.url_id";
		$sql = "SELECT $fields FROM (SELECT url $fromJoin
			WHERE $where) AS t1 WHERE url NOT IN (SELECT url $fromJoin WHERE $where);";
		return DB::select($sql, [$crawl_id, $cmp_crawl_id]);
		//[0]->total
	}

	public static function addedDuplicatedUrls($crawl_id, $cmp_crawl_id, $action="") {
		$fields = UrlStatus::getFields($action);
		$where = "crawl_id = ? GROUP BY title, meta_desc, url_short";
		$fromJoin = "FROM url_status us JOIN url u ON u.id = us.url_id";
		$sql = "SELECT $fields FROM (SELECT url $fromJoin
			WHERE $where) AS t1 WHERE url NOT IN (SELECT url $fromJoin WHERE $where);";
        return DB::select($sql, [$crawl_id, $cmp_crawl_id]);
		//[0]->total
	}
	
	public static function addedPaginatedUrls($crawl_id, $cmp_crawl_id) {
		return UrlStatus::paginated($crawl_id)
			->whereNotIn('url.url', function ($sql) use($cmp_crawl_id) {
				UrlStatus::joinAndFilter($sql, $cmp_crawl_id)
					->where('url_status.pagination', '<>', '')
					->whereNotNull('url_status.pagination');
			});
	}
	
	public static function addedCanonicalUrls($crawl_id, $cmp_crawl_id) {
		return UrlStatus::canonical($crawl_id)
			->whereNotIn('url.url', function ($sql) use($cmp_crawl_id) {
				UrlStatus::joinAndFilter($sql, $cmp_crawl_id)
					->whereNotNull('url_status.canonical');
			});
	}

	public static function addedResponseCodeUrls($crawl_id, $cmp_crawl_id, $code) {
		return UrlStatus::responseCodeUrls($crawl_id, $code)
			->whereNotIn('url.url', function ($sql) use($cmp_crawl_id, $code) {
				UrlStatus::joinAndFilter($sql, $cmp_crawl_id)
					->where('url_status.url_status_code', '=', $code);
			});
	}
	
	public static function addedNonZeroFieldUrls($crawl_id, $cmp_crawl_id, $field) {
		$_field = String::quoteIdentifier($field);
		return UrlStatus::nonZero($crawl_id)
			->whereNotIn('url.url', function ($sql) use($cmp_crawl_id, $_field) {
				UrlStatus::joinAndFilter($sql, $cmp_crawl_id)
					->where("url_status.$_field", '<>', 0)
					->whereNotNull("url_status.$_field");
			});
	}

    public static function getFromWebsiteExcept($website_id, $date, $not_this_code){
        $sql = 'SELECT  url_status_code, 
						count(*) AS amount 
			FROM `url_status`
            JOIN url AS u ON u.id=url_status.url_id
            WHERE u.website_id=? 
				AND url_status.reported_on = ? 
				AND url_status_code != ?
            GROUP BY url_status_code
            ORDER BY url_status_code ASC';

        return DB::select($sql, [$website_id, $date, $not_this_code]);
    }

    public static function getCountFromWebsiteExcept($website_id, $date, $not_this_code){
        $sql = 'SELECT 
				count(*) AS amount 
			FROM `url_status`
            JOIN url AS u ON u.id=url_status.url_id
            WHERE u.website_id=? 
				AND url_status.reported_on = ? 
				AND url_status_code != ?';
        $data = DB::select($sql, [$website_id, $date, $not_this_code]);
        return isset($data[0]) ? $data[0]->amount : 0;
    }

}