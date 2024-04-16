<?php

class Website extends \Eloquent {

    use SoftDeletingTrait;
	protected $table = "website";
    protected $dates = ['deleted_at'];
	protected $fillable = ['name','url','description','status','max_urls','schedule','root_url'];
	
	public static $max_urls_choices = [0=>100000, 2=>5000, 3=>10000]; // max URLs to crawl
	public static $schedule_choices = [0=>'daily', 1=>'weekly', 2=>'biweekly', 3=>'monthly'];
	public static $rules = [
		'name' => 'required|max:100',
		'url' => 'required|url|max:255',
	];

    public function gwt_dumps() {
        return $this->hasMany('GwtDump');
    }
	
	public function crawls() {
        return $this->hasMany('Crawl');
    }
	
	public function users() {
		return $this->belongsToMany('User');
	}


	public static function historicUrlsCount($website_id) {
		$sql = "SELECT worked_on, SUM(amount) as amount
			FROM crawl_stats cs
			JOIN crawl c ON c.id = cs.crawl_id
			WHERE c.website_id = ?
				AND cs.description = 'All URLs'
				AND typ = 'overview'
			GROUP BY worked_on";
		return DB::select($sql, [$website_id]);
	}
	
	public static function historicCount($website_id, $description) {
		$sql = "SELECT worked_on, SUM(amount) as amount
			FROM crawl_stats cs
			JOIN crawl c ON c.id = cs.crawl_id
			WHERE c.website_id = ?
				AND cs.description = ?
			GROUP BY worked_on";
		return DB::select($sql, [$website_id, $description]);
	}
	
	public static function historicNon200($website_id) {
		$sql = "SELECT worked_on, SUM(amount) as amount
			FROM crawl_stats cs
			JOIN crawl c ON c.id = cs.crawl_id
			WHERE c.website_id = ?
				AND cs.description NOT IN ('200 OK')
				AND cs.typ = 'Response Codes' 
			GROUP BY worked_on";
		return DB::select($sql, [$website_id]);
	}
	
	/** 
	 * <code>
	 * select name, url, max(worked_on), count(*) from website w
	 * join crawl c on c.website_id = w.id; 
	 * </code>
	 */
	public static function datatableFromUser($user_id){
		$last_crawl_date = "(select x.worked_on from crawl x order by x.worked_on desc limit 1)";

		return Website::join('website_user', function($join) use($user_id) {
			$join->on('website.id','=','website_user.website_id');
			$join->on('website_user.user_id','=', DB::raw($user_id) );
		})
//		->leftjoin('crawl AS c', function($join) {
//			$join->on('website.id','=','c.website_id');
//		})
		->where('website.status', '=', 1)
		->select(array(
			'website.id',
			'website.name',
			'website.url',
			'website.max_urls',
			'website.schedule',
			DB::raw('(SELECT max(c.worked_on) FROM crawl AS c WHERE c.website_id=website.id) AS last_crawl_date'),
			DB::raw('(SELECT count(*) FROM crawl AS c WHERE c.website_id=website.id) AS total_crawls')
		));
	}

	public static function websitesByUserDataTable($user_id) {
		$last_crawl_date = "select x.worked_on from crawl x order by x.worked_on desc limit 1";
		$sql = "select
				w.id, w.name, w.url, ws.risk_level as weekly_risk_level, was.average 
			from website w
			join crawl 						c on w.id = c.website_id
			join website_status 			ws on w.id = ws.website_id
			join website_availability_stats was on w.id = was.website_id
			join website_user 				wu on w.id = wu.website_id
			where c.worked_on = ($last_crawl_date)
			    and ws.reported_on = ($last_crawl_date) and ws.type = 1
			    and was.created_for = ($last_crawl_date) and was.type = 1
			    and wu.user_id = ?";
		return DB::select(DB::raw($sql), [$user_id]);
	}

	/* Dashboard functions */

	public static function availability($the_date, $website_id, $user_id){
		return DB::table('website_availability_stats')
		->join('website_user', function($join) use( $user_id ){
			$join->on('website_availability_stats.website_id','=','website_user.website_id');
			$join->on('website_user.user_id','=', DB::raw($user_id) );
		})
		->where('website_availability_stats.website_id','=',$website_id)
		->where('website_availability_stats.type','=', DB::raw(0) )
		->where(DB::raw('DATE(website_availability_stats.created_for)'),'=', $the_date )
		->pluck('average');
	}

	public static function historicAvailabilities($the_date, $website_id, $user_id){
		return DB::table('website_availability_stats')
		->join('website_user', function($join) use( $user_id ){
			$join->on('website_availability_stats.website_id','=','website_user.website_id');
			$join->on('website_user.user_id','=', DB::raw($user_id) );
		})
		->where('website_availability_stats.website_id','=',$website_id)
		->where(DB::raw('DATE(website_availability_stats.created_for)'),'=', $the_date )
		->select(['type','average'])
		->orderBy('type')->get();
	}

	public static function getRiskLevelsByMonth($website_id, $year, $month, $user_id){
		return DB::table('website_status')
		->join('website_user', function($join) use( $user_id ){
			$join->on('website_status.website_id','=','website_user.website_id');
			$join->on('website_user.user_id','=', DB::raw($user_id) );
		})
		->select('risk_level', DB::raw('DAYOFMONTH(reported_at) AS day') )
		->where('website_status.website_id','=',$website_id)
		->where(DB::raw('YEAR(website_status.reported_at)'),'=',$year)
		->where(DB::raw('MONTH(website_status.reported_at)'),'=',$month)
		->get();
	}

	/**
	 * select * from website w
	 * join crawl c on c.website_id = w.id
     * where c.id=15;
	 * @param type $crawl_id
	 * @return Website
	 */
	public static function byCrawl($crawl_id) {
		return Website::join('crawl', function($join) use($crawl_id){
			$join->on('website.id','=','crawl.website_id');
			$join->on('crawl.id','=', DB::raw($crawl_id));
		})
		->select('website.id', 'website.name', 'website.url', 'website.root_url');
	}
}