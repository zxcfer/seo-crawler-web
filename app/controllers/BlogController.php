<?php

class BlogController extends BaseController {

    /**
     * Post Model
     * @var Post
     */
    protected $post;

    /**
     * User Model
     * @var User
     */
    protected $user;
	
    /**
     * User Model
     * @var company
     */
    protected $company;
    
    /**
     * Inject the models.
     * @param Post $post
     * @param User $user
     */
    public function __construct(Post $post, User $user, Company $company)
    {
        parent::__construct();
		
        $this->beforeFilter('@loadSearchData');
        
        $this->post = $post;
        $this->user = $user;
        $this->company = $company;
        
    }
    
    public function loadSearchData() //$route, $request
    {
    	$data['categories'] = Config::get('const.CATEGORIES');
    	$data['types']		= Config::get('const.TYPES');
    	$data['regions']	= $this->loadSelectWithRegions();
    }
    
	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		$data['categories'] = Config::get('const.CATEGORIES');
		$data['types']		= Config::get('const.TYPES');
		$data['regions']	= $this->loadSelectWithRegions();

		// Get all the blog posts
		$data['posts']	= $this->post->orderBy('created_at', 'DESC')->paginate(10);
		
		// Log::info(print_r($regions, true));
		
		// Show the page
		return View::make('site/blog/index', $data);
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
	
	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug)
	{
		// Get this blog post data
		$post = $this->post->where('slug', '=', $slug)->first();

		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that
			// a page or a blog post didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}

		// Get this post comments
		$comments = $post->comments()->orderBy('created_at', 'ASC')->get();

        // Get current user and check permission
        $user = $this->user->currentUser();
        $canComment = false;
        if(!empty($user)) {
            $canComment = $user->can('post_comment');
        }

        $categories = Config::get('const.CATEGORIES');
        $types = Config::get('const.TYPES');
        $regions = $this->loadSelectWithRegions();

		// Show the page
		return View::make('site/blog/view_post', compact('post', 'comments', 'canComment', 'categories', 'types', 'regions'));
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug)
	{

        $user = $this->user->currentUser();
        $canComment = $user->can('post_comment');
		if ( ! $canComment)
		{
			return Redirect::to($slug . '#comments')->with('error', 'You need to be logged in to post comments!');
		}

		// Get this blog post data
		$post = $this->post->where('slug', '=', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Save the comment
			$comment = new Comment;
			$comment->user_id = Auth::user()->id;
			$comment->content = Input::get('comment');

			// Was the comment saved with success?
			if($post->comments()->save($comment))
			{
				// Redirect to this blog post page
				return Redirect::to($slug . '#comments')->with('success', 'Your comment was added with success.');
			}

			// Redirect to this blog post page
			return Redirect::to($slug . '#comments')->with('error', 'There was a problem adding your comment, please try again.');
		}

		// Redirect to this blog post page
		return Redirect::to($slug)->withInput()->withErrors($validator);
	}
	

	/**
	 * View a create blog post form.
	 *
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getCreatePost()
	{
		// Get current user and check permission
		$user = $this->user->currentUser();
		if(!empty($user)) {
			
		}
		
		$categories = Config::get('const.CATEGORIES');
		$types = Config::get('const.TYPES');
		$regions = $this->loadSelectWithRegions();		
		
		return View::make('site/blog/new_post', compact('categories', 'types', 'regions'));
	}
	
	/**
	 * Create a blog post anonimously.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postCreatePost()
	{
	
       // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3',
            'content' => 'required|min:3',
        	'email'   => 'required|min:3',
        	'name'    => 'required|min:3',
        	'g-recaptcha-response' => 'required|recaptcha',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);
        
        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
            $this->post->title            = Input::get('title');
            $this->post->slug             = Str::slug(Input::get('title'));
            $this->post->content          = Input::get('content');
            
            $this->post->meta_title       = str_replace(' ', '-', $this->post->title);
            $this->post->meta_description = '';
            $this->post->meta_keywords    = '';
            $this->post->user_id    	  = 2;
            
            $this->company->user_id    	  = 2;
            $this->company->name    	  = Input::get('name');;
            $this->company->description	  = Input::get('description');
            $this->company->status 		  = 'A';
            $this->company->url			  = Input::get('website');

            // Was the blog post updated?
            if($this->post->save() && $this->company->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/blogs/' . $this->post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/blogs/' . $this->post->id . '/edit')->with('error', Lang::get('admin/blogs/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('nuevo/')->withInput()->withErrors($validator);
	}

	/**
	 * Search posts filters.
	 *
	 * @return Redirect
	 */
	public function searchView()
	{
		$categories = Config::get('const.CATEGORIES');
		$types = Config::get('const.TYPES');
		$regions = $this->loadSelectWithRegions();
		
		// get search form inputs
		$keyword 	= trim(Input::get('keyword'));
		$region_id 	= Input::get('region');
		$age		= Input::get('age');
		$type 		= Input::get('type');
		$company 	= Input::get('company');
		$category 	= Input::get('category');
		$date 		= Input::get('date');
		
		// select all Active posts
		$posts = $this->post->where("status", "=", "A");

		// check if filters are set
		if ($keyword != "")
			$posts = $posts->where("title", "=", $keyword);

		if ($region_id != "" && $region_id != "0")
		 	$posts = $posts->where('region_id', '=', $region_id);

		if ($type != "")
			$posts = $posts->where('type', '=', $type);

		if ($category!= "")
			$posts = $posts->where('category', '=', $category);

		// date(age-longevity) filter
		$start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-60, date('Y')));
		if ($age == 'last24') {
			$start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-1, date('Y')));
		} elseif ($age == 'lastweek') {
			$start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-8, date('Y')));
		} elseif ($age == 'lastmonth') {
			$start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-30, date('Y')));
		}

		$posts = $posts->whereBetween('created_at', array($start_date, date('Y-m-d')));
		
		// order by creation date
		$posts = $posts->orderBy('created_at', 'DESC')->paginate(10);
		
		// load previous inputs
		Input::flash();

		return View::make('site/blog/index', compact('posts', 'categories', 'types', 'regions'));
	}

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function dashboardView()
	{
		$title = 'Jobs Posted';
		return View::make('site/blog/dashboard', compact('title'));
	}
	
	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function dashboardJsonView()
	{
		$posts = Post::select(array('posts.id', 'posts.title', 'posts.id as comments', 'posts.created_at'));
	
		return Datatables::of($posts)
	
		->edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}')
		->add_column('actions', 
				'<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')
		->remove_column('id')
		->make();
	}
}

