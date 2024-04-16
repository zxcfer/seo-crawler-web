<?php

class GwtError extends \Eloquent {

	public $timestamps = false;
    protected $table = "gwt_error_samples";
	protected $fillable = [
		'page_url','category','platform','last_crawled',
		'first_detected','response_code','gwt_dump_id'];

}