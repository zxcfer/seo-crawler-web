@extends('site.layouts.default')

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/jquery.jqplot.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/c3.min.css')}}">
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-lg-3">
	  <div class="panel panel-default">
	    <div class="panel-heading">
			<strong>Project Settings</strong>
	    </div>

		<div class="panel-body">
			<form id="website-form-update" method="post" class="form-horizontal"
				  action="{{ URL::route('website_update', $website->id) }}">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				
				<div><h5>Crawl Limit</h5></div>
				{{ Form::select('max_urls', Website::$max_urls_choices, $website->max_urls, array('class' => 'form-control')) }}
				<div><h5>Scheduling</h5></div>
				{{ Form::select('schedule', Website::$schedule_choices, $website->schedule, array('class' => 'form-control')) }}
				<h5><a id="submit-save" class="form-control btn btn-success">Save</a></h5>

				<div><h4>Google Web Master</h4>
					<input class="form-control" name="gwm_email" />
					<button >Verify</button>
				</div>
				<div><h4>XML Site Map locations</h4>
					<input name="gwm_email" class="form-control"/>
					<p><button>Submit</button><p>
				</div>
			</form>
		</div>
	  </div>
	</div>
	
	<div class="col-lg-9">
	  <div class="panel panel-default">
		  <div class="panel-body">
			<div class="btn-group btn-group" style="">
			<a id="crawl-list" href="#" class="btn btn-default active">
				Crawls List<span class="glyphicon"></span></a>
			<a id="gwt-dump-list" href="#" class="btn btn-default gwt-dumps">
				Google Webmaster Tools Data<span class="glyphicon"></span></a>
			</div>
		  </div>
	  </div>
	</div>
	
	<div class="col-lg-9">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <strong>Crawl List</strong>
	    </div>
	    <div class="panel-body">
		  <table id="detail" class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="col-md-3">Complete Crawls</th>
					<th id="table-title-2" class="col-md-2">Levels</th>
					<th id="table-title-3" class="col-md-2">No of URLs</th>
					<th class="col-md-2">Actions</th>
                </tr>
			</thead>
			<tbody></tbody>
		  </table>
      </div>
	  </div>
	</div>

</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Web Crawl URLs</strong>
      </div>
      <div class="panel-body">
        <div class='chart'>
          <div id="web-crawl-urls"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Google Web Master Tools Errors</strong>
      </div>
      <div class="panel-body">
        <div class='chart'>
          <div id="riskchart"></div>
        </div>
      </div>
    </div>
  </div>
	<div class="col-lg-12">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <strong>Website Availability</strong>
	    </div>
	    <div class="panel-body">
        <div class='chart' style="height: 300px">
          <div id="chart"></div>
        </div>
	    </div>
	  </div>
	</div>
</div>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/c3.min.js') }}"></script>
<script type="text/javascript">
var home_url = "{{ URL::route('home') }}";
var crsf_token = '{{{ csrf_token() }}}';
var url = "{{ URL::to('crawls_data/' . $website->id ) }}";
var oTable = Ajax.detailDataTable(url);

	$("#crawl-list").on("click", function(e) {
		oTable.fnReloadAjax(url);
		$("#crawl-list").addClass('active');
		$("#gwt-dump-list").removeClass('active');
		$("#table-title-2").text('Levels');
		$("#table-title-3").text('No of URLs');
	});

	$("#gwt-dump-list").on("click", function(e) {
		var dumps_url = "{{ URL::route('gwt-dumps', $website->id) }}";
		oTable.fnReloadAjax(dumps_url);
		$("#crawl-list").removeClass('active');
		$("#gwt-dump-list").addClass('active');
		$("#table-title-2").text('Sitemaps');
		$("#table-title-3").text('Errors');
	});

	$("#submit-save").on("click", function(e) {
		Ajax.postForm("#website-form-update", function (data, status) {
			$.notify({title: "Welcome:", message: "saved" });
		});
	});

	appUrls = new App('URLs')
	appUrls.columnFormatC3({{ json_encode($historic_urls) }});
	appUrls.drawLineChart('#web-crawl-urls');
	
	drawBarChart =  function (chart_id, columns) {
		var chart = c3.generate({
			bindto: chart_id,
		    data: { columns: [columns], },
		});
	}

	var chart2 = c3.generate({
		bindto: "#chart",
	    data: {
	        columns: [['Availability', {{ $availabilities_list }} ]],
	        types: { Availability: 'bar' }
	    },
	    axis: {
          rotated: true,
          x: { type: 'category', categories: ['8 hrs', '24 hrs', '7 days', '30 days'] },
	        y: { max: 92, padding: 0, tick: { format: function (d) { return d+"%"; } } }
	    },
	    color: {
	        pattern: ['#60B044', '#F6C600', '#F97600', '#FF0000'],
	        threshold: { values: [25, 50, 75, 100] }
	    },
	    size: { height: 270 }
	});
</script>

<script type="text/javascript">

</script>
@stop