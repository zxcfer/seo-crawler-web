<?php

class Sitemap extends \Eloquent {

	public $timestamps = false;
	protected $table = "gwt_sitemap";
	protected $fillable = [
		'site_url',
		'path',
		'type',
		'errors',
		'warnings',
		'last_submitted',
		'gwt_dump_id'
	];
	
}
