<?php

class WebsitesConfController extends \BaseController {

	var $website;

    public function __construct()
    {
        parent::__construct();
        // $this->beforeFilter('@getWebsite', array('website_id' => $website_id));
    }

	public function getWebsite($website_id) {
		try {
			$website = Website::findOrFail($website_id);
			Session::put('website_id', $website_id);
			Session::put('website_name', $website->name);
		} catch(Exception $e) {
			return Redirect::route('websites.index');
		}
		return $website;
	}

	public function index($website)
	{
		$this->website = $website;
		$data = array(
			'title' => 'Website Settings',
			'website' => $this->website
		);
		
		return View::make('site.websitesconf.users')->with($data);
	}

	public function websiteUsersData($website)
	{
		try {
			$users = User::find(Auth::id());
			$users = DB::table('users')->select(['username','email']);
		} catch(Exception $e){
			return Response::json(array('error' => $website->id));
		}

		return Datatables::of($users)
			->edit_column('username', '<span>{{ $username }}</span>')
			->edit_column('email', '<span>{{ $email }}</span>')
		->make();
	}

	public function confirmDeleteUserFromWebsite($website_id, $user_id){

	}

	public function addUserToWebsite($website_id, $user_id){

	}

	public function manageUrls($website){

	}

	public function activityLog($website){
		$this->website = $website;
		$data = array(
			'title' => 'Website Activity Log',
			'website' => $this->website
		);
		
		return View::make('site.websites.activity')->with($data);
	}

	
	public function urlAlertdata(Website $website){
		$severity = Input::get('severity', array(0,1,2,3));
		$url_alerts = UrlAlert::getAlertDatatable( Auth::id(), $severity, $website->id);

		return Datatables::of($url_alerts, true)
			->edit_column('severety', '@if( $severety == 0)
        		<span class="label label-success">GREEN</label>
        		@elseif ($severety == 1)
        		<span class="label label-yellow">YELLOW</label>
        		@elseif ($severety == 2)
        		<span class="label label-warning">ORANGE</label>
        		@else ($severety == 3)
        		<span class="label label-danger">RED</label>
        		@endif')
			->edit_column('description', '<span>{{ $description }}</span>')
			->edit_column('url', '<a href="{{ $url }}" target="_blank">{{ Str::limit($url, 70, "...") }}</a>')
			->edit_column('reported_on', '{{ date("d M Y",strtotime($reported_on)) }}')
		->make();
	}

}
