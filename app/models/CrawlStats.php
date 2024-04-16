<?php

class CrawlStats extends Eloquent {

    protected $table = "crawl_stats";
	protected $fillable = ['amount'];
	public static $create_update = " NOW() AS created_at, NOW() AS updated_at ";
	
    public function id() {
        return $this->id;
    }
	
	public function _table() {
		return $this->prop_table;
	}

	public function _id() {
		return $this->prop_id;
	}

	protected $appends = array('div_id','subtyp_desc_id', 'description_url');

	public function getDivIdAttribute() {
		if ($this->subtyp !== NULL) {
			$subtyp = $this->subtyp;
		} else {
			$subtyp = "null";
		}
		return String::urlize($this->typ.'_'.$subtyp.'_'.$this->description);
	}
	
	public function getDescriptionUrlAttribute() {
		return String::urlize($this->description);
	}

	public function getSubtypDescIdAttribute() {
		return String::urlize($this->subtyp.'_'.$this->description);
	}
	
	public static function getStats($crawl, $typ = NULL, $subtyp = NULL) {
		$stats = CrawlStats::where('crawl_id', '=', $crawl->id);
		if ($typ) {
			$stats = $stats->where('typ','=',$typ);
		}
		if ($subtyp) {
			$stats = $stats->where('subtyp','=',$subtyp);
		}
		return $stats->get();
	}
	
	public static function historicStats($crawl, $typ) {
		$sql =	"SELECT * FROM crawl_stats cs
			WHERE crawl_id IN (SELECT id FROM crawl WHERE website_id = ?)
			AND typ = ?";
		return DB::select($sql, [$crawl->website_id, $typ]);
	}
	
    public static function stats($crawl, $typ = NULL, $subtyp = NULL) {
		$stats = CrawlStats::getStats($crawl, $typ, $subtyp);
		if (sizeof($stats) > 0) {
			return $stats;
		} else {
			CrawlStats::urlStats($crawl->id);
			CrawlStats::alertStats($crawl);
			CrawlStats::responseCodesStats($crawl->id);
			CrawlStats::robotsStats($crawl->id);
			return CrawlStats::getStats($crawl, $typ, $subtyp);
		}
    }

	public static function responseCodesStats($crawl_id) {
		DB::statement(CrawlStats::responseCodeCount('200', '200 OK'), [$crawl_id, $crawl_id]);
		DB::statement(CrawlStats::responseCodeCount('404', '404 OK'), [$crawl_id, $crawl_id]);
		DB::statement(CrawlStats::responseCodeCount('301', '301 Redirect'), [$crawl_id, $crawl_id]);
		DB::statement(CrawlStats::responseCodeCount('302', '302 Redirect'), [$crawl_id, $crawl_id]);
	}
	
	public static function count_robots($robot) {
		return "INSERT INTO crawl_stats 
			(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		SELECT 
			'url_status'	AS prop_table,
			UPPER('$robot')	AS description,
			count(*)		AS amount,
			?				AS crawl_id,
			'robots'		AS typ,
			".CrawlStats::$create_update."
		FROM url_status 
		WHERE crawl_id = ? AND robots_$robot=1";
	}
	
	public static function count_urls($type) {
		return "INSERT INTO crawl_stats 
			(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		SELECT 
			'url_status'	AS prop_table,
			'All URLs'		AS description,
			count(*)		AS amount,
			?				AS crawl_id,
			'$type'			AS typ,
			".CrawlStats::$create_update."
		FROM url_status
		WHERE crawl_id = ?";
	}
	
	public static function responseCodeCount($value, $name) {
		return "INSERT INTO crawl_stats
			(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		SELECT
			'url_status'		AS prop_table,
			'$name'				AS description,
			count(*)			AS amount,
			?					AS crawl_id,
			'Response Codes'	AS typ,
			".CrawlStats::$create_update."
		FROM url_status 
		WHERE crawl_id = ? AND url_status_code = '$value'";
	}

	public static function count_field($field, $description = NULL) {
		return "INSERT INTO crawl_stats 
			(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		SELECT 
			'url_status'	AS prop_table,
			'$description'	AS description, 
			count(*)		AS amount,
			?				AS crawl_id,
			'indexation'	AS typ,
			".CrawlStats::$create_update."
		FROM url_status 
		WHERE crawl_id = ? AND $field IS NOT NULL AND $field != ''";
	}
	
	public static function count_social($field, $category) {
		return "INSERT INTO crawl_stats 
			(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		SELECT 
			'url_status'	AS prop_table,
			'$field'		AS description, 
			count(*)		AS amount, 
			?				AS crawl_id,
			'indexation'	AS typ,
			".CrawlStats::$create_update."
		FROM url_status 
		WHERE crawl_id = ? AND $field IS NOT NULL AND $field = '$category'";
	}
	
	public static function sum_field($field, $type, $description=NULL) {
		if ($description === NULL) {
			$description = str_replace('_', ' ', $field);
		}
		
		return "INSERT INTO crawl_stats
			(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		SELECT
			'url_status'	AS prop_table,
			'$description'	AS description,
			sum($field)		AS amount,
			?				AS crawl_id,
			'$type'			AS typ,
			".CrawlStats::$create_update."
		FROM url_status 
		WHERE crawl_id = ? AND $field IS NOT NULL";
	}
	
	public static function count_total_images($type, $crawl_id) {
		$total = count(Image::allByCrawl($crawl_id)->get());
		
		return "INSERT INTO crawl_stats
		(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		VALUES ('images', 'images', $total, ?, '$type', NOW(), NOW())";
	}
	
	public static function count_no_alt_images($type, $crawl_id) {
		$total = count(Image::noAltbyCrawl($crawl_id)->get());
		
		return "INSERT INTO crawl_stats
		(prop_table, description, amount, crawl_id, typ, created_at, updated_at)
		VALUES ('images', 'no-alt-images', $total, ?, '$type', NOW(), NOW())";
	}	
	
	public static function unique_count($crawl_id) {
		$sql = "SELECT count(*) AS total
			FROM url_status us
			JOIN url u ON u.id = us.url_id
			WHERE us.crawl_id = ?
			GROUP BY title, meta_desc, url_short";
		return DB::select($sql, [$crawl_id]);
	}
	
	// TODO: not working
	public static function unique_duplicated($crawl_id) {
		$uc = CrawlStats::unique_count($crawl_id);
		$total = 0;
		$unique = 0;
		foreach ($uc as $x) {
			$total = $total + $x->total;
			$unique = $unique + 1;
		}
		
		$duplicated = $total - $unique;
		$insert = "INSERT INTO crawl_stats
			(description, amount, typ, crawl_id, created_at, updated_at)
			VALUES ('unique', $unique, 'indexation', ?, NOW(), NOW()),
			       ('duplicated', $duplicated, 'indexation', ?, NOW(), NOW())";
		DB::statement($insert, [$crawl_id, $crawl_id]);
	}
	
	public static function urlStats($crawl_id) {
		$crawl_param = [$crawl_id, $crawl_id];
		DB::statement(CrawlStats::count_urls('overview'), $crawl_param);
		DB::statement(CrawlStats::count_total_images('overview', $crawl_id), [$crawl_id]);
		DB::statement(CrawlStats::count_urls('indexation'), $crawl_param);
		CrawlStats::unique_duplicated($crawl_id);
		DB::statement(CrawlStats::count_field('pagination', 'paginated'), $crawl_param);
		DB::statement(CrawlStats::count_field('canonical', 'canonical'), $crawl_param);
		return;
    }

	public static function robotsStats($crawl_id) {
		$robots = ['index','noindex','follow','nofollow','noarchive','nosnippet','noodp','noydir'];
		foreach ($robots as $robot) {
			DB::statement(CrawlStats::count_robots($robot), [$crawl_id, $crawl_id]);
		}
	}
	
	public static function alertStats($crawl) {
		$insert = "INSERT INTO crawl_stats (prop_id, prop_table, description, 
			amount, severety, subtyp, typ, crawl_id, created_at, updated_at)
		SELECT 
			a.id			AS prop_id, 
			'alert'			AS prop_table,
			a.description	AS description, 
			count(ua.id)	AS amount, 
			a.severety		AS severety,
			a.typ			AS typ,
			'on-site'		AS subtyp,
			?		        AS crawl_id,
			".CrawlStats::$create_update."
		FROM alert AS a
		LEFT JOIN url_alert AS ua ON ua.alert_id = a.id AND ua.crawl_id = ?
		LEFT JOIN url		AS u ON u.id = ua.url_id
		WHERE typ IS NOT NULL
		GROUP BY a.id ORDER BY a.typ DESC";
		DB::statement($insert, [$crawl->id, $crawl->id]);
		$crawl_id = $crawl->id;
		
//		DB::statement(CrawlStats::sum_field('images', 'images'), [$crawl->id, $crawl->id]);
//		DB::statement(CrawlStats::sum_field('no_alt_images', 'images'), [$crawl->id, $crawl->id]);
		DB::statement(CrawlStats::count_total_images('images', $crawl_id), [$crawl_id]);
		DB::statement(CrawlStats::count_no_alt_images('images', $crawl_id), [$crawl_id]);
		
		$struct = "Structured Data";
		DB::statement(CrawlStats::sum_field('struct_product', $struct), [$crawl->id, $crawl->id]);
		DB::statement(CrawlStats::sum_field('struct_offer', $struct), [$crawl->id, $crawl->id]);
		DB::statement(CrawlStats::sum_field('struct_aggreg', $struct,
			'struct aggregation'), [$crawl->id, $crawl->id]);
		DB::statement(CrawlStats::sum_field('struct_review', $struct), [$crawl->id, $crawl->id]);
		DB::statement(CrawlStats::sum_field('struct_rating', $struct), [$crawl->id, $crawl->id]);
	}

	/**
	 * Check if this CrawlStats is contained by a set of CrawlStats
	 */
	public function in($set) {
		foreach ($set as $inner){
			if ($inner->typ == $this->typ
					&& $inner->subtyp == $this->subtyp
					&& $inner->description == $this->description) {
				return $inner;
			}
		}
        return false;
	}
}