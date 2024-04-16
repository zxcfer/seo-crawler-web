@extends('site.layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/c3.min.css') }}" />
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-lg-4">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <strong>Changes</strong>
	    </div>
	    <div class="panel-body">
			<div id="tree"></div>
            <br />
		</div>
	  </div>
	</div>

		<div class="col-lg-5 panel-chart">
		  <div class="panel panel-default">
			<div class="panel-heading">
			  <strong>Crawled URLs</strong>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div id="piechart"></div>
			</div>
		  </div>
		</div>

		<div class="col-lg-3 panel-chart">
		  <div class="panel panel-default">
			<div class="panel-heading">
			  <strong>Quick Check</strong>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<table class="table table-condensed table-striped">

				</table>
			</div>
		  </div>
		</div>	
		
		<div class="col-lg-8 panel-chart">
		  <div class="panel panel-default">
			<div class="panel-heading">
			  <strong>Web Crawl URL</strong>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
			  <div id="web-crawl-depth-chart"></div>
			</div>
			<!-- /.panel-body -->
		  </div>
		  <!-- /.panel -->
		</div>

	<div class="col-lg-8 panel-chart">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Duplicated Pages</strong>

      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div class='chart'>
          <div id='robots'>
            <div id="duplicated-pages-chart"></div>
          </div>
        </div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>

  <div class="col-lg-8 panel-chart">
  	<div class="panel panel-default">
      <div class="panel-heading">
        <strong>Non 200 Status</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div id="non-200-status"></div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
	
	<div class="col-lg-8">
    <div id="detail-datatable" class="panel panel-default hidden">
      <div class="panel-heading">
        <strong id="detail-title" style="font-size: 20px">All URLs</strong>
		<a href="#" id="csv-button" class="btn btn-large pull-right">CSV<span class="glyphicon glyphicon-download-alt"></span></a>
      </div>
	  <div class="panel-body">
		<table id="detail" class="table table-striped table-hover">
		  <thead>
			<tr>
              <th class="col-md-2">URL</th>
			  <th class="col-md-2">Crawl Date</th>
			</tr>
		  </thead>
		  <tbody></tbody>
		</table>
	  </div>
	</div>
	</div>
</div>

@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/c3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/tree.js') }}"></script>
<script type="text/javascript">
	home_url = "{{ URL::route('home') }}";
	crawl_id = "{{{ $crawl->id }}}";
	start_url = "{{ URL::route('non-zero-urls', [$crawl->id, 'all-urls']) }}";
	oTable = Ajax.detailDataTable(start_url);
</script>
<script type="text/javascript" src="{{ asset('assets/js/pages/crawl.dashboard.js') }}"></script>
<script type="text/javascript">
	var tree = getTree({{ json_encode($stats) }});
	$('#tree').treeview({data: tree});
	$('#tree').treeview('expandAll', { levels: 2, silent: true });

	indexation_stats = {{ json_encode($indexation_stats) }}
	pie_items = []
	for (i in indexation_stats) {
		indstat = indexation_stats[i];
		if (indstat['description']!=='All URLs')
			pie_items.push([indstat['description'],	indstat['amount']]);
	}
	
	var piechart = c3.generate({
		bindto: '#piechart',
		data: { columns: pie_items, type : 'pie' },
		size: { height: 260 },
	});

	$(document).ready(function() {
		appUrls = new App('URLs')
		appUrls.columnFormatC3({{ json_encode($historic_urls) }});
		appUrls.drawLineChart('#web-crawl-depth-chart');

		appDuplicated = new App('Duplicated')
		appDuplicated.columnFormatC3({{ json_encode($historic_duplicated) }});
		appDuplicated.drawLineChart('#duplicated-pages-chart');

		appNon200 = new App('Non 200 status')
		appNon200.columnFormatC3({{ json_encode($historic_non_200) }});
		appNon200.drawLineChart('#non-200-status');		
	});

	$('.comp-crawl-select').on("change", getCompareTree);
	$('.tree-stat').on("click", reloadDataTable);

</script>
@stop