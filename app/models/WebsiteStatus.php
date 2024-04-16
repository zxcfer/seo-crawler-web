<?php

class WebsiteStatus extends Eloquent {

  protected $table = "website_status";

  public function __construct()
  {
      
  }

  public function id()
  {
    return $this->id;
  }

  public static function risk($website_id, $crawl_date) {
    return DB::table('website_status')
      ->select('risk_level', 'reported_on')
      ->where('website_status.website_id','=',$website_id)
      ->where('reported_on','=',$crawl_date)
      ->first();
  }

  //->where(DB::raw('DATE(reported_at)'),'=',$crawl_date)

  public static function last_risks($website_id) {
    return DB::table('website_status')
      ->select('risk_level', 'reported_on')
      ->where('website_status.website_id','=',$website_id)
      ->orderBy('reported_on', 'desc')->take(4)->get();
  }
}