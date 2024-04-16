<?php

class Image extends Eloquent {
    protected $table = "crawl";
	protected $fillable = ['src', 'alt', 'response_code', 'url_status_id'];
	
	public static function fields() {
		// $count = DB::raw("CONCAT(count(*), '___',images.src) as url");
		return [
			'images.src as url',
			'images.id',
			// DB::raw("count(*) as total"),
			'url_status.created_at'
		];
	}
	
	public static function allByCrawl($crawl_id) {
		return DB::table('images')
		->join('url_status', function($join) use($crawl_id) {
			$join->on('url_status.id','=','images.url_status_id');
			$join->on('url_status.crawl_id','=', DB::raw($crawl_id));
		})
		->select(self::fields())
		->groupBy('images.src');
    }

	public static function noAltbyCrawl($crawl_id) {
		return DB::table('images')
		->join('url_status', function($join) use($crawl_id) {
			$join->on('url_status.id','=','images.url_status_id');
			$join->on('url_status.crawl_id','=', DB::raw($crawl_id));
		})
		->where(function($query) {
			$query->where('images.alt', '=', '');
			$query->orWhereNull('images.alt');
		})
		->select(self::fields())
		->groupBy('images.src');
    }	
}
