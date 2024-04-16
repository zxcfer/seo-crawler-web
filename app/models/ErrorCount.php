<?php

class ErrorCount extends \Eloquent {

	public $timestamps = false;
	protected $table = "gwt_error_count"; //gwt_error_samples
	protected $fillable = ['category','platform','total','gwt_dump_id'];

}