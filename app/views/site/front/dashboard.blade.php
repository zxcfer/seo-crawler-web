@extends('site.layouts.default')

@section('styles')
	
#chart div {
  font: 12px sans-serif;
  background-color: green;
  text-align: right;
  padding: 6px;
  margin: 1px;
  color: white;
}
.danger-date {
  background-color: #337ab7;
  color: #ffffff;		
}
@stop 

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			Dashboard
		</h3>
	</div>


<div class="row">
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <strong>Change Monitor - Prevous 2 hrs</strong>
	    </div>
	    <div class="panel-body">
        <div class='chart'>
          <div id='gauge-chart'></div>
        </div>
      </div>
	  </div>
	</div>

	<div class="col-lg-6">
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <strong>Website Availability</strong>
	    </div>
	    <!-- /.panel-heading -->
	    <div class="panel-body">
        <div class='chart'>
          <div id="chart"></div>
        </div>
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
        <strong>Content Type Overview</strong>
      </div>
      <div class="panel-body">
		<div class="container">
		    <div class="col-sm-6">
		        <div class="form-group">
		            <div class="row">
		                <div class="col-md-8">
		                    <div id="datetimepicker12"></div>
		                </div>
		            </div>
		        </div>
		    </div>

		</div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Content Type </strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <div class='chart'>
          <div id='content_type_piechart'></div>
        </div>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
</div>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/c3.min.js') }}"></script>

<script type="text/javascript">
	var chart = c3.generate({
		bindto: '#gauge-chart',
	    data: {
	        columns: [
	            ['data', 91.4]
	        ],
	        type: 'gauge',
	        onclick: function (d, i) { console.log("onclick", d, i); },
	        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
	        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
	    },
	    gauge: {

	    },
	    color: {
	        pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'],
	        threshold: {
	            values: [30, 60, 90, 100]
	        }
	    },
	    size: {
	        height: 180
	    }
	});
</script>

<script type="text/javascript">
	drawBarChart =  function (chart_id, columns, columns_groups) {
		var chart = c3.generate({
			bindto: "#change-vol",
		    data: {
		    	x: 'x',
		        columns: columns,
		        type: 'bar',
		        groups: [columns_groups]
		    },
		    axis: {
		        x: { type: 'category' }
		    },
		    grid: { y: { lines: [{ value:0 }] } },
		    legend: { position: 'right' }
		});
	}
</script>

<script type="text/javascript">
	var data = [80, 80, 100, 90, 100, 100];

	var x = d3.scale.linear()
	    .domain([0, d3.max(data)])
	    .range([0, 350]);

	d3.select("#chart")
	  .selectAll("div")
	    .data(data)
	  .enter().append("div")
	    .style("width", function(d) { return x(d) + "px"; })
	    .text(function(d) { return d+'%'; });

</script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker12').datetimepicker({
            inline: true,
            //sideBySide: true
        });
    });

    if ($('td.day').text() == '12') {
    	
    }
    
    $('td.day').addClass('danger-date');
    
</script>

@stop