<?php

class GwtDump extends \Eloquent {

	protected $table = "gwt_dump";
	protected $fillable = ['site_url', 'website_id'];

	public function website() {
        return $this->belongsTo('Website');
    }

	public function sitemaps() {
        return $this->hasMany('Sitemap');
    }
	
	public function errors() {
        return $this->hasMany('GwtError');
    }

	public function errorCounts() {
        return $this->hasMany('ErrorCount');
    }
	
	public static function byWebsite($website_id) {
		$total_errors = "(select count(*) FROM gwt_error_samples "
			. "WHERE gwt_error_samples.gwt_dump_id=gwt_dump.id) AS total_errors";
		$total_sitemaps= "(select count(*) FROM gwt_sitemap "
			. "WHERE gwt_sitemap.gwt_dump_id=gwt_dump.id) AS total_sitemaps";
		
        return GwtDump::where('website_id','=',$website_id)
			->select(array(
				'gwt_dump.id',
				'gwt_dump.created_at',
				DB::raw($total_sitemaps),
				DB::raw($total_errors)
			))
		    ->orderBy('created_at', 'desc');
    }
	
	public static function already_dumped() {
		$sql = "SELECT * FROM gwt_dump WHERE month(created_at) = month(now())";
		$dump = DB::select($sql);
		if (sizeof($dump) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public static function error_counts_chart($gwt_dump) {
		return DB::table('gwt_error_count')
		->where('gwt_dump_id','=',$gwt_dump->id)
		->select('gwt_dump_id', DB::raw('count(*) as total'))
		->groupBy('gwt_dump_id')->get();
	}
}
