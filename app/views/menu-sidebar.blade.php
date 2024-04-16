<div class="sidebar-nav" style="padding: 20px 0px 0px 0px; width: 100%;">
	<div class="well">

		@if (isset($website))
		<h3><a href="{{ URL::to('websites/'.$website->id) }}">{{{ $website->name }}}</a></h3>
		<div class="row">
			<div class="col-lg-6">
				<a href="{{ $website->root_url }}">{{ $website->root_url }}</a>
			</div>
			<div class="col-lg-6">
				@if(str_contains(Request::url(), 'crawl'))
				<form id="date-filter" class="form-inline form-group"  style="float:right">
					<strong>Crawl Date:</strong>
					<a class="form-control">{{ $crawl->worked_on }}</a>
					<strong>Compared to:</strong>
					{{ Form::select('prevCrawlId', 
							array('1' => '-- Select') + $prevCrawls,
							Input::old('prevCrawlId'), 
							array('class' => 'form-control comp-crawl-select')) }}
				</form>
				@endif
			</div>
		</div>
		@endif
		
		@if (isset($settings))
		<ul class="nav nav-tabs">
			<li><a href="{{ URL::to('website-alerts/'.$website->id) }}"
				   class="btn btn-default">Manage Alerts<span class="glyphicon"></span></a></li>
			<li><a href="{{ URL::to('website-urls/'.$website->id) }}"
				   class="btn btn-default">Manage URLs<span class="glyphicon"></span></a></li>
			<li><a href="{{ URL::to('website-users/'.$website->id) }}"
				   class="btn btn-default">Manage Users<span class="glyphicon"></span></a>	</li>		
		</ul>
		@endif
	</div>
</div>

@if(str_contains(Request::url(), 'crawl'))
<div class="btn-group btn-group" style="margin-bottom: 20px;">
	<a href="{{ URL::to('crawl/dashboard/'.$crawl->id ) }}" class="btn {{$dashboard}} btn-default">
		Dashboard<span class="glyphicon"></span></a>
	<a href="{{ URL::to('crawl/indexation/'.$crawl->id ) }}" class="btn {{$indexation}} btn-default">
		Indexation<span class="glyphicon"></span></a>
	<a href="{{ URL::to('crawl/on-site/'.$crawl->id ) }}" class="btn {{$on_site}} btn-default">
		On-Site<span class="glyphicon"></span></a>
	<a href="{{ URL::to('crawl/response-codes/'.$crawl->id ) }}" class="btn {{$response_codes}} btn-default">
		Response Codes<span class="glyphicon"></span></a>
</div>
@endif

@if(str_contains(Request::url(), 'gwt-dump'))
<div class="btn-group btn-group" style="margin-bottom: 20px;">
	<a href="{{ URL::route('gwt-sitemaps', $gwtDump->id) }}" class="btn {{$sitemaps}} btn-default">
		Sitemaps<span class="glyphicon"></span></a>
	<a href="{{ URL::route('gwt-errors', $gwtDump->id) }}" class="btn {{$gwt_errors}} btn-default">
		Errors<span class="glyphicon"></span></a>
</div>
@endif