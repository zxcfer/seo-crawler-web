@extends('site.layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/jquery.jqplot.css') }}" />
@stop
@section('styles')
.overview-graph { height: 210px; width: 100%; }
.depth-graph { height: 280px; width: 100%; }
@stop 

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{$title}}}
		</h3>
	</div>


<div class="row">
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <strong>Changes</strong>
	    </div>
	    <div class="panel-body">
            @forelse($changes_groups as $k => $changes)
            <strong>Severity: {{ Alert::$SEVERETIES[$k] }}</strong>
            <table class="table table-condensed table-striped">
            @forelse($changes as $change)
                <tr>
                    <td><span class="{{ isset(Alert::$COLORS[$change->severety]) ? Alert::$COLORS[$change->severety] : '' }}">{{ $change->description }}</span></td>
                    <td style="font-size: 125%;font-weight:bold; color: red;">{{ isset($change->difference)? $change->difference : $change->amount }}</td>
                </tr>
            @empty
                <tr><td>No data available</td></tr>
            @endforelse
            </table>
            @empty
            @endforelse
            <br />
            <div class="well well-sm">
            This crawl: {{ isset($crawl->worked_on) ? $crawl->worked_on : '' }}<br />
            Previous crawl: {{ isset($previous_crawl->worked_on) ? $previous_crawl->worked_on : '' }}<br />
            </div>

        <!--
        <div class='chart'>
          <div id='gauge-chart'></div>
        </div>
        -->
      </div>
	  </div>
	</div>

	<div class="col-lg-6">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <strong>Issues</strong>
	    </div>
	    <!-- /.panel-heading -->
	    <div class="panel-body">
            <table class="table table-condensed table-striped">
            @forelse($issues as $issue)
                <tr>
                    <td>{{ $issue->description }}</td>
                    <td style="font-size: 125%;font-weight:bold; color: red;">{{ $issue->amount }}</td>
                </tr>
            @empty
                <tr><td>No data available</td></tr>
            @endforelse
            </table>
        <!--
        <div class='chart' style="height: 210px">
          <div id="chart"></div>
        </div>
        -->
	    </div>
	    <!-- /.panel-body -->
	  </div>
	  <!-- /.panel -->
	</div>
</div>
<div class="row">
  <!-- /.col-lg-6 -->
  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Non 200 status code pages</strong>
      </div>
      <div class="panel-body">
            <table class="table table-condensed table-striped">
                <tr><td>Total</td><td>{{ $status_not_200_total }}</td></tr>
            @foreach($status_not_200 as $status)
                <tr>
                    <td>{{ $status->url_status_code }}</td>
                    <td>{{ $status->amount }}</td>
                </tr>
            @endforeach
            </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Robots</strong>

      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div class='chart'>
          <div id='robots'>
            <table class="table table-condensed table-striped">
                <tr><td>Robots index: </td><td>{{ $robots_index }}</td></tr>
                <tr><td>Robots follow: </td><td>{{ $robots_follow }}</td></tr>
            </table>
          </div>
        </div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>


  	<div class="col-lg-12">
  	<div class="panel panel-default">
      <div class="panel-heading">
        <strong>Web Crawl Depth</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div id="web-crawl-depth" class="depth-graph"></div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>

  	<div class="col-lg-12">
  	<div class="panel panel-default">
      <div class="panel-heading">
        <strong>Paginated Pages Trend</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div id="paginated-pages-trend" class="overview-graph"></div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>

  	<div class="col-lg-12">
  	<div class="panel panel-default">
      <div class="panel-heading">
        <strong>Non-200 Status Codes Trend</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div id="non-status-trend" class="overview-graph"></div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>

</div>

@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/jquery.jqplot.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jqplot.canvasTextRenderer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jqplot.dateAxisRenderer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jqplot.canvasAxisLabelRenderer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jqplot.dateAxisRenderer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jqplot.highlighter.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jqplot.enhancedLegendRenderer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/overview.js') }}"></script>
<script>
xs = [
  {{ json_encode( $depth_params_failed_urls ) }},
  {{ json_encode( $depth_params_paginated_pages ) }},
  {{ json_encode( $depth_params_non_200_status ) }},
  {{ json_encode( $depth_params_200_status ) }}
];

// axis inverse
xx=[];
for (j in xs) {
  var x = xs[j];

  // fill zeros
  z= [];
  for (var n=0; n<11; n++) {
    z.push([n,0]);
  }

  // switch x to y
  for (i in x) {
    if (i>=11) {
      z.push([i,0]);
    }
    z[i][0]=x[i][1];
    z[i][1]=x[i][0];
  }
  xx.push(z);
}

jQuery(document).ready(function(){
    var depth_trend = generateDepthGraph('web-crawl-depth', xx, "Web Crawl Depth", 280, [
            {label:'Failed URLs',renderer:$.jqplot.LineRenderer, color:'#3A7CFF'},
            {label:'Paginated Pages',renderer:$.jqplot.LineRenderer, color:'#FFB43A'},
            {label:'Non-200',renderer:$.jqplot.LineRenderer, color:'red'},
            {label:'Status 200',renderer:$.jqplot.LineRenderer, color:'#2E8B32'},
        ]);

    var plot_trend = generatePagesGraph( 'non-status-trend', [{{ json_encode( $not_200_graph ) }}], 'Non-200 Status Codes Trend', 210 );
    var paginated_trend = generatePagesGraph( 'paginated-pages-trend', [{{ json_encode( $paginated_pages_graph ) }}], 'Paginated Pages Trend', 210 );
});
</script>
@stop