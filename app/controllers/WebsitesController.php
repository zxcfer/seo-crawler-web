<?php
class WebsitesController extends \BaseController {
	var $TRASH = '<i class="glyphicon glyphicon-trash">';
	public static $TRASH1 = '<span class="glyphicon glyphicon-trash"></span>';
	public static $PENCIL = '<span class="glyphicon glyphicon-pencil"></span>';
	
    public function index() {
        $data = array('title' => 'List of Websites');
        return View::make('site.websites.index')->with($data);
    }
    
    public function data() {
        $websites = Website::datatableFromUser(Auth::id());
        return Datatables::of($websites)
            ->edit_column('name', 
			'<a href="{{{ URL::to(\'websites/\'. $id ) }}}"><strong>{{ $name }}</strong></a>')
            ->edit_column('url', '<a href="{{{ $url }}}">{{ $url }}</a>')
            ->edit_column('last_crawl_date', 
				'<div class="centered">{{{ $last_crawl_date }}}</div>')
            ->edit_column('total_crawls', 
				'<div class="centered">{{{ $total_crawls }}}</div>')
            ->add_column('actions', '
			<a href="#" class="edit" id="{{$url}}__{{$id}}__{{$name}}__{{$max_urls}}__{{$schedule}}">'.self::$PENCIL.'</a>
			<a href="#" class="delete" id="delete-{{$id}}-{{$name}}">'.self::$TRASH1.'</a>')
            ->remove_column('id')
			->remove_column('max_urls')
			->remove_column('schedule')
			->make();
    }

    public function urlAlertdata(Website $website) {
        $crawl = Crawl::last($website->id);

        $severity = Input::get('severity', array(0,1,2,3));
        $url_alerts = UrlAlert::getDatatableListFromUser(
            Auth::id(), $severity, $website->id, $crawl->worked_on);

        return Datatables::of($url_alerts)
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
			->make();
    }

    public function show($website_id) {
        try {
            $website = Website::findOrFail($website_id);
        } catch (Exception $e){
            return Redirect::route('websites.index');
        }

        $the_date = date('Y-m-d');

        $availabilities = Website::historicAvailabilities($the_date, $website_id, Auth::id());
        $availabilities_list = array();
        foreach($availabilities as $av){
            $availabilities_list[] = $av->average;
        }

        $data = array(
            'crawl' => Crawl::last($website_id),
            'website' => $website,
            'title' => 'Websites - Dashboard',
            'availability' => Website::availability($the_date, $website_id, Auth::id()),
            'availabilities_list' => implode( ', ', $availabilities_list),
            'historic_urls' => Website::historicUrlsCount($website->id)
        );
        return View::make('site.websites.show', $data);
    }

    /**
     * Show the form for creating a new website
     *
     * @return Response
     */
    public function create() {
        $data = array(
            'website' => new Website(),
            'title' => 'Websites - Create',
            'method' => 'POST',
            'form_url' => URL::to('websites')
        );

        return View::make('site.websites.create_edit', $data);
    }

    /**
     * Store a newly created website in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Website::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $website = Website::create($data);
        if (isset($website->id)){
            DB::table('website_user')->insert([
				'user_role' => 1,
				'website_id' => $website->id,
				'user_id' => Auth::id()
            ]);
        }
        return Redirect::to('websites/'.$website->id.'/edit')->with('success', 'Website created succesfully' );
    }

    /**
     * Show the form for editing the specified website.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $website = Website::select('website.url','website.name')
            ->join('website_user', function($join){
                $join->on('website.id','=', 'website_user.website_id');
                $join->on('website_user.user_id','=', DB::raw( Auth::id() ) );
            })
            ->findOrFail($id);

        $data = array(
            'website' => $website,
            'title' => 'Websites - Edit',
            'method' => 'PUT',
            'form_url' => URL::to('websites/'.$id)
        );
        return View::make('site.websites.create_edit', $data);
    }

    public function update($id) {
        $website = Website::findOrFail($id);
        
        $validator = Validator::make($data = Input::all(), Website::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $website->update($data);

        return Redirect::to('websites/'.$website->id.'/edit')->with('success', 'Website updated succesfully' );
    }
    
    public function apiCreate() {
		$website_id = Input::get("website_id", "");
		if ($website_id !== "") {
			return $this->apiUpdate($website_id);
		}
		
        try {
            $validator = Validator::make($data = Input::all(), Website::$rules);
            if ($validator->fails()) {
                $resp = $this->json_resp("no", "Update failed.");
            }
			
            $data['root_url'] = $data['url']; 
            $website = Website::create($data);
            if (isset($website->id)) {
                DB::table('website_user')->insert([
					'user_role' => 1,
                    'website_id' => $website->id,
                    'user_id' => Auth::id()
                ]);
            }
            $resp = $this->json_resp("yes", "Website created succesfully: {$website->id}");
        } catch (Exception $e) {
            $resp = $this->json_resp("no", "Can't create: ".$e->getMessage());
        }
        
        return Response::json($resp);
    }
	
    
    public function json_resp($status, $message) {
        return ['updated' => $status, 
                'message' => $message];
    }
    
    public function apiUpdate($id) {
        try {
            $website = Website::findOrFail($id);
			$website->name = Input::get('name', $website->name);
			$website->url = Input::get('url', $website->url);
			$website->root_url = Input::get('root_url', $website->url);
            $website->max_urls = Input::get('max_urls');
            $website->schedule = Input::get('schedule');
            $x = "[".$website->max_urls."-".$website->schedule."]";
            $website->update();
            $resp = ['updated' => 'yes', 'message' => "Website updated succesfully: $x"];
        } catch (Exception $e){
            $resp = ['updated' => 'no', 'message' => 'Update failed'.$e->getMessage()];
        }
        
        return Response::json($resp);
    }

    public function confirmDelete($website_id) {
        try {
            $website = Website::findOrFail($website_id);
            $website->delete();
        } catch (Exception $e){
            return Response::json(array('deleted' => 'false'));
        }
        
        return Response::json(array('deleted' => 'true'));
    }

    public function destroy($id) {
        Website::destroy($id);
        return Redirect::route('websites.index');
    }
}
