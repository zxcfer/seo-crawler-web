<?php

class Crawl extends Eloquent {

    protected $table = "crawl";

    public static $SEVERETIES = [
       '0' => 'None',
       '1' => 'Bad',
       '2' => 'Very bad',
       '3' => 'Severe'];

    public function id()
    {
        return $this->id;
    }
 
    public static function last($website_id)
    {
        return Crawl::where('website_id','=',$website_id)
            ->orderBy('worked_on', 'desc')->first();
    }

	public static function prevCrawls($currentCrawl, $limit=10)
    {
        return Crawl::where('website_id','=',$currentCrawl->website_id)
			->where('worked_on', '<', $currentCrawl->worked_on)
            ->orderBy('worked_on', 'desc')
			->take($limit)->lists('worked_on', 'id');
    }

	public static function previousTo($website_id, $crawl)
    {
        return Crawl::where('website_id','=',$website_id)
            ->where('worked_on', '<', $crawl->worked_on)
            ->orderBy('worked_on', 'desc')->first();
    }

	public static function previous($crawl)
    {
        return Crawl::where('website_id','=',$crawl->website_id)
            ->where('worked_on', '<', $crawl->worked_on)
            ->orderBy('worked_on', 'desc')->first();
    }

	public static function get($website_id, $worked_on)
    {
        return Crawl::where('website_id','=',$website_id)
            ->where('worked_on', '=', $worked_on)
            ->first();
    }

    public static function byWebsite($website)
    {
		$crawls = Crawl::where('website_id','=',$website->id);
		
		// if crawler is running, do not show the last crawls in the list
		if ($website->status == 2) {
			$last_crawl_date = "(SELECT worked_on FROM crawl
								 WHERE website_id={$website->id}
								 ORDER BY worked_on DESC LIMIT 1)";
			$crawls = $crawls->where('worked_on', '<', DB::raw($last_crawl_date));
		}
		
		$count_urls = '(SELECT max(depth) FROM url_status WHERE crawl_id=crawl.id) AS depth';
		$max_depth = "(SELECT count(*) FROM url_status WHERE crawl_id=crawl.id) AS urls";
        return $crawls->select(array(
				'crawl.id',
				'crawl.worked_on',
				'crawl.notes',
				DB::raw($count_urls),
				DB::raw($max_depth),
			))
		    ->orderBy('worked_on', 'desc');
    }
}
