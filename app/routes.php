<?php

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');
Route::model('website', 'Website');
Route::model('crawl', 'Crawl');

// Route::model('gwtDump', 'GwtDump');
Route::bind('gwtDump', function($id) {
    return GwtDump::with('website')->findOrFail($id);
});

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('crawl', '[0-9]+');
Route::pattern('gwtDump', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('blogs', 'AdminBlogsController');

    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});

# Posts - Second to last set, match slug
//Route::get('nuevo', 'BlogController@getCreatePost');
//Route::post('nuevo', 'BlogController@postCreatePost');

//Route::get('oferta-trabajo/{postSlug}', 'BlogController@getView');
//Route::post('oferta-trabajo/{postSlug}', 'BlogController@postView');

//Route::get('search', 'BlogController@searchView');
//Route::get('dashboard', 'DashboardController@getIndex');
//Route::get('dashboardjson', 'BlogController@dashboardJsonView');

Route::group(array('before'=>'auth'), function() {
    Route::post('websites/confirm_delete/{website_id}', array(
		'as' => 'website_delete',
		'uses' => 'WebsitesController@confirmDelete'));
	Route::post('websites/api/update/{website_id}', array(
		'as' => 'website_update',
		'uses' => 'WebsitesController@apiUpdate'));
	Route::post('websites/api/create', array(
		'as' => 'website_create',
		'uses' => 'WebsitesController@apiCreate'));
    Route::post('crawl/confirm_delete/{crawl}', array(
		'as' => 'crawl_delete',
		'uses' => 'CrawlController@confirmDelete'));


    //Json
    Route::get('websites_data', 'WebsitesController@data');
	Route::get('stats-diff/{crawl}/{cmpCrawl}/{typ}', array(
		'as' => 'stats-diff',
		'uses' => 'DashController@diffJson'));

	// Detail Datatables
	Route::get('crawl/{crawl}/indexation/{description}', array(
		'as' => 'indexation-urls',
		'uses' => 'IndexationController@indexationData'));
	Route::get('crawl/{crawl}/on-site-urls/{subtyp}/{description}', array(
		'as' => 'on-site-urls',
		'uses' => 'OnSiteController@onSiteDataTables'));
	Route::get('crawl/{crawl}/response-codes-urls/{code}', array(
		'as' => 'response-codes-urls',
		'uses' => 'ResponseCodesController@responseCodesDataTables'));
	Route::get('crawl/{crawl}/non-zero/{field}', array(
		'as' => 'non-zero-urls',
		'uses' => 'DashController@nonZeroDataTables'));

	// Added / Removed Datatables
	Route::get('added/indexation/{description}/{crawlId}/{cmpCrawlId}/', array(
		'as' => 'indexation-added-urls',
		'uses' => 'IndexationController@addedIndexationDataTable'));
	Route::get('added/on-site/{subtyp}/{description}/{crawlId}/{cmpCrawlId}/', array(
		'as' => 'on-site-added-urls',
		'uses' => 'OnSiteController@addedOnSiteDataTable'));
	Route::get('added/response-codes/{description}/{crawlId}/{cmpCrawlId}/', array(
		'as' => 'response-codes-added-urls',
		'uses' => 'ResponseCodesController@addedResponseCodesDataTables'));
	Route::get('added/other/{description}/{crawlId}/{cmpCrawlId}/', array(
		'as' => 'other-added-urls',
		'uses' => 'DashController@addedNonZeroFieldDataTables'));

	// Google Webmaster Toolkit
	Route::get('website/{website}/gwt-dumps', array(
		'as' => 'gwt-dumps',
		'uses' => 'GwtDumpController@dumpsDataTables'));
	
	Route::get('gwt-dump/{gwtDump}/sitemaps', array(
		'as' => 'gwt-sitemaps',
		'uses' => 'GwtDumpController@index'));
	Route::get('gwt-dump/{gwtDump}/errors', array(
		'as' => 'gwt-errors',
		'uses' => 'GwtDumpController@gwtErrors'));
	
//	Route::get('gwt-dump/{gwtDump}/sitemaps', array(
//		'as' => 'gwt-sitemaps',
//		'uses' => 'GwtDumpController@sitemapsDataTables'));
//	Route::get('gwt-dump/{gwtDump}/errors', array(
//		'as' => 'gwt-errors',
//		'uses' => 'GwtDumpController@errorsDataTables'));

    Route::get('website_alerts_data/{website}', 'WebsitesController@urlAlertdata');
	Route::get('crawls_data/{website}', 'CrawlController@crawlsData');

    Route::resource('websites', 'WebsitesController');
    //Route::controller('website_users', 'WebsiteUsersController');

	//Route::get('website-users-data/{website}', 'WebsitesController@riskByTypesData');
    //Route::controller('website_urls', 'WebsiteUrlsController');

	Route::get('crawl/dashboard/{crawl}', 'DashController@index');
	Route::get('crawl/indexation/{crawl}', 'IndexationController@index');
	Route::get('crawl/on-site/{crawl}', 'OnSiteController@index');
	Route::get('crawl/response-codes/{crawl}', 'ResponseCodesController@index');
	Route::get('crawl/robots/{crawl}', 'RobotsController@index');

    Route::get('overview/{website}', 'WebsitesOverviewController@index');
    Route::get('content/{website}', 'WebsitesContentController@index');

    Route::get('website-users/{website}', 'WebsitesConfController@index');
    Route::get('website-users-data/{website}', 'WebsitesConfController@websiteUsersData');
    Route::get('website-urls/{website}', 'WebsitesUrlsController@index');
    Route::get('website-alerts/{website}', 'WebsitesAlertsController@index');

    Route::get('activity-log/{website}', 'WebsitesConfController@activityLog');
    Route::get('activity-log-data/{website}', 'WebsitesConfController@urlAlertdata');
});

# Index Page - Last route, no matches
#Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
Route::get('/', array(
	'as' => 'home',
	'before' => 'detectLang',
	'uses' => 'FrontController@getIndex'));
