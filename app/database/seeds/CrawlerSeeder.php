<?php

class CrawlerSeeder extends Seeder {

    public function run()
    {
        $crawl_table = DB::table('crawl');

        $crawl_table->delete();

//         $dates = DB::select('SELECT DISTINCT (url_alert.reported_on), website_id
//             FROM `url_alert` JOIN url ON url.id = url_alert.url_id GROUP BY reported_on, website_id');
// 
//         foreach($dates as $date){
//             $crawl_id = $crawl_table->insert([
//                 'notes' => 'Crawl date generated from seeder',
//                 'worked_on' => $date->reported_on,
//                 'website_id' => $date->website_id
//             ]);
//         }
    }
}
