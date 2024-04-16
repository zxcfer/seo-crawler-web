<?php

class FrontController extends BaseController {

    protected $user;

    public function __construct(User $user)
    {
        parent::__construct();
		
        $this->beforeFilter('@baseDataLoad');
        $this->user = $user;
        
    }
    
    public function baseDataLoad() //$route, $request
    {
    }
    
	public function getIndex()
	{
		$data['categories'] = Config::get('const.CATEGORIES');
		$data['types']		= Config::get('const.TYPES');
		$data['regions']	= $this->loadSelectWithRegions();
		// Log::info(print_r($regions, true));
		
		return View::make('site/front/home', $data);
	}


	public function loadSelectWithRegions()
	{
		$regions = array(0 => '-- Choose location');
		$regionz = Region::where('country', '=', 'PE')->select(array('id', 'name'))->get();
		foreach ($regionz as $region) {
			$regions[$region->id] = $region->name;
		}
		return $regions;
	}


}

