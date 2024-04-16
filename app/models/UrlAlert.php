<?php

class UrlAlert extends \Eloquent {

	protected $table = "url_alert";

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	protected $fillable = ['url_id','reported_on','alert_id'];

	public static function onSite($crawl_id, $subtyp, $description) {
		return DB::table('url_alert')
			->join('url', 'url.id', '=', 'url_alert.url_id')
			->join('alert', 'alert.id', '=', 'url_alert.alert_id')
			->join('crawl', 'crawl.id', '=', 'url_alert.crawl_id')
			->select(['url.url', 
					  'url_alert.id', 
					  'crawl.worked_on'])
            ->where('url_alert.crawl_id', '=', $crawl_id)
			->where(DB::raw("REPLACE(alert.description,' ','-')") , '=', $description)
			->where('alert.typ', '=', $subtyp);
	}

	public static function addedOnSiteUrls($crawlId, $cmpCrawlId, $subtyp, $description) {
		return UrlAlert::onSite($crawlId, $subtyp, $description)
			->whereNotIn('url.url', function ($sql) use($cmpCrawlId, $subtyp, $description) {
				$sql->select('url.url')->from('url_alert')
				->join('url', 'url.id', '=', 'url_alert.url_id')
				->join('alert', 'alert.id', '=', 'url_alert.alert_id')
				->join('crawl', 'crawl.id', '=', 'url_alert.crawl_id')
				->where('url_alert.crawl_id', '=', $cmpCrawlId)
				->where(DB::raw("REPLACE(alert.description,' ','-')") , '=', $description)
				->where('alert.typ', '=', $subtyp);
			});
	}
//
//	public static function count($crawl_id, $cmp_crawl_id, $subtyp, $description) {
//		$where = "crawl_id = ? 
//			AND REPLACE(a.description,' ','-') = ?
//			AND a.typ = ?";
//		$fromJoin = "FROM url_alert ua
//			JOIN url u ON u.id = ua.url_id
//			JOIN alert a ON a.id = ua.alert_id
//			JOIN crawl c ON c.id = ua.crawl_id";
//		$sql = "SELECT count(u.url) AS total $fromJoin
//			WHERE $where AND url NOT IN (SELECT url $fromJoin WHERE $where);";
//		
//        return DB::select($sql, [
//			$crawl_id, $description, $subtyp, 
//			$cmp_crawl_id, $description, $subtyp
//		])[0]->total;
//	}

	public static function getDatatableListFromUser(
        $user_id, $severity, $website_id, $reported_on) {
		$clean_sev = [];
		foreach($severity as $sev) { $clean_sev[] = (int) $sev; }

		return DB::table('url_alert')
			->join('url','url.id','=','url_alert.url_id')
			->join('website_user', function($join) use( $user_id ){
        		$join->on('website_user.website_id','=','url.website_id');
        		$join->on('website_user.user_id','=', DB::raw($user_id) );
        	})
        	->leftjoin('alert', function($join) use( $clean_sev ) {
        		$join->on('alert.id','=','url_alert.alert_id');
	 	        if(count($clean_sev)){
		        	$join->on('alert.severety', 'in', DB::raw( '(' . implode( ',',  $clean_sev ) .')' ) );
		        }
        	})
        	->select(['alert.severety', 'alert.description', 'url.url'])
            ->where('url.website_id','=', $website_id)
            ->where('url_alert.reported_on', '=', $reported_on)
        	->orderBy('alert.severety','desc');
	}

    public static function getAlertDatatable($user_id, $severity, $website_id){
        $clean_sev = array();
        foreach($severity as $sev) {
            $clean_sev[] = (int) $sev;
        }

        $query = DB::table('url_alert')
            ->join('url','url.id','=','url_alert.url_id')
            ->join('website_user', function($join) use( $user_id ){
                $join->on('website_user.website_id','=','url.website_id');
                $join->on('website_user.user_id','=', DB::raw($user_id) );
            })
            ->leftjoin('alert', function($join) use( $clean_sev ){
                $join->on('alert.id','=','url_alert.alert_id');
                if(count($clean_sev)){
                    $join->on('alert.severety', 'in', DB::raw( '(' . implode( ',',  $clean_sev ) .')' ) );
                }
            })
            ->select(['alert.severety',
                'alert.description',
                'url.url',
                'url_alert.reported_on'
            ])
            ->where('url.website_id','=', $website_id)
            ->orderBy('url_alert.reported_on','desc');
        return $query;
    }

    public static function getCountByDate($date, $website_id, $user_id){
        $query = DB::table('url_alert')
            ->join('url','url.id','=','url_alert.url_id')
            ->join('website_user', function($join) use( $user_id ){
                $join->on('website_user.website_id','=','url.website_id');
                $join->on('website_user.user_id','=', DB::raw($user_id) );
            })
            ->join('alert', function($join) use( $clean_sev ){
                $join->on('alert.id','=','url_alert.alert_id');
            })
            ->groupBy('alert.severity')
            ->select(DB::raw('COUNT(*) AS count'),'alert.severity')
            ->where('reported_on' >= $date )
            ->where('website.id','=', $website_id);
        return $query->get();
    }

    public static function countBySeverety($website_id, $date){
        $SQL_COUNT_BY_SEVERETY = 
            "SELECT
				alert.severety as severety, 
				count(ua.id) as count 
			FROM url_alert ua
            JOIN url ON url.id = ua.url_id
            JOIN alert ON alert.id = ua.alert_id
            WHERE ua.reported_on = :reported_on
                AND url.website_id = :website_id
            GROUP BY alert.severety";

        $query = DB::select( DB::raw($SQL_COUNT_BY_SEVERETY), array(
           'reported_on' => $date,
           'website_id' => $website_id
        ));

        return $query;
    }

    public static function getCountByDateRange($start_date, $website_id, $user_id){
        if ($start_date == 'LAST_DAY') {
            $start_timestamp = 'DATE_SUB(NOW(), INTERVAL 7 DAY)';
        } elseif ($start_date == 'LAST_WEEK') {
            $start_timestamp = 'DATE_SUB(NOW(), INTERVAL 24 HOUR)';
        }

        $query = DB::table('url_alert')
            ->join('url','url.id','=','url_alert.url_id')
            ->join('website_user', function($join) use( $user_id ){
                $join->on('website_user.website_id','=','url.website_id');
                $join->on('website_user.user_id','=', DB::raw($user_id) );
            })
            ->join('alert', function($join) use( $clean_sev ){
                $join->on('alert.id','=','url_alert.alert_id');
            })
            ->groupBy('alert.severity')
            ->select(DB::raw('COUNT(*) AS count'),'alert.severity')
            ->where(DB::raw("created_at BETWEEN $start_timestamp AND NOW()"))
            ->where('website.id','=', $website_id);
        return $query->get();
    }


    public static function getOverviewChangesInformation(
		$website_id, $date, $previous_date){
        $sql = 'SELECT 
				ua.alert_id, 
				a.description, 
				count(ua.id)-count(ub.id) AS difference, 
				a.severety 
			FROM url_alert AS ua
            LEFT JOIN url_alert AS ub ON ua.url_id = ub.url_id 
				AND ua.alert_id=ub.alert_id 
				AND ub.reported_on=?
            JOIN alert			AS a ON a.id = ua.alert_id
            JOIN url			AS u ON u.id = ua.url_id
            WHERE u.website_id = ? 
				AND ua.reported_on = ?
            GROUP BY alert_id HAVING difference > 0 
			ORDER BY difference DESC';
        return DB::select($sql, [$previous_date, $website_id, $date]);
    }

    /* Mover a Alert?? */
    public static function getContentInformation(
			$website_id, $date, $ids= array()) {

        $ids_query = implode(',', $ids);

        $sql = "SELECT 
				a.id AS alert_id, 
				a.description, 
				(SELECT COUNT(*) AS c
					FROM url_alert AS ua
					JOIN url AS u ON ua.url_id=u.id 
						AND u.website_id = ? 
					WHERE ua.alert_id=a.id
					AND ua.reported_on = ?) AS amount
            FROM alert AS a 
			WHERE a.id IN ($ids_query)
            ORDER BY a.id ASC";

        return DB::select($sql, [$website_id, $date]);
    }
	
    public static function formatAlerts($url_alerts) {
    
        $output = array();
        foreach($url_alerts as $url_alert) {
            $output[$url_alert->alert_id] = $url_alert;
        }
        return $output;
    }

}