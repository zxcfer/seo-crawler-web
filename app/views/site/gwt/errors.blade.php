@extends('site.layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/c3.min.css') }}" />
@stop

{{-- Content --}}
@section('content')
<div class="row">
  <!-- /.col-lg-6 -->
  <div class="col-lg-12">
	  
	<div class="panel panel-default">
	  <div class="panel-heading">
		<strong>Error Counts</strong>
	  </div>
	  <!-- /.panel-heading -->
	  <div class="panel-body">
		<div class='chart'>
		  <div id='robots'>
			<div id="error-count-chart"></div>
		  </div>
		</div>
	  </div>
	  <!-- /.panel-body -->
	</div>

  	<div class="panel panel-default">
      <div class="panel-heading">
        <strong style="font-size: 20px">{{ $subtitle }}</strong>
		<a href="?format=csv" id="csv-button" class="btn btn-large pull-right">
			CSV<span class="glyphicon glyphicon-download-alt"></span></a>
      </div>
      
      <div class="panel-body">
	    <table class="table table-striped table-bordered table-hover dataTable no-footer no-padding" id="serptable">
          <thead>
            <tr>
              <th>URL</th>
              <th class="centered">Category</th>
              <th>Platform</th>
              <th>Response Code</th>
			  <th>Last Crawled</th>
			  <th>First Detection</th>
            </tr>
          </thead>
          <tbody id="list_tbody">
			@forelse($gwtDump->errors as $gwt_error)
            <tr>
			  <td>{{ $gwt_error->page_url }}</td>
              <td>{{ $gwt_error->category }}</td>
              <td class="centered">{{ $gwt_error->platform }}</td>
              <td class="centered">{{ $gwt_error->response_code }}</td>
              <td class="centered">{{ $gwt_error->last_crawled }}</td>
              <td class="centered">{{ $gwt_error->first_detected }}</td>
            </tr>
			@empty
			<tr><td colspan="6">There is no errors</td></tr>
            @endforelse
          </tbody>
        </table>
	  </div>
	<!-- /.panel-body -->
    </div>

  </div>
</div>
@stop


{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/c3.min.js') }}"></script>
<script type="text/javascript">
	var error_counts = {{ json_encode($errorCountsChart) }};
	console.log(error_counts);
	$(document).ready(function() {
		appUrls = new App('Errors');
		appUrls.columnFormatErrorCount(error_counts);
		appUrls.drawLineChart('#error-count-chart');
	});
</script>
@stop