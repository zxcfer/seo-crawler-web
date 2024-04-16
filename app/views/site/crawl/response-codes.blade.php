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
        <strong style="font-size: 20px">{{ $subtitle }}</strong>
      </div>
      
      <div class="panel-body">
	    <table class="table table-striped table-bordered table-hover dataTable no-footer no-padding" id="serptable">
          <thead>
            <tr>
              <th>Alert</th>
              <th class="centered">Total</th>
			  @if(isset($compCrawl))
              <th>Added since {{ $compCrawl->worked_on }}</th>
              <th>Removed since {{ $compCrawl->worked_on }}</th>
			  @else
              <th></th>
              <th></th>
			  @endif
            </tr>
          </thead>
          <tbody id="list_tbody">
			@forelse($stats as $stat)
            <tr>
			  <td>
				  <div class="row vcenter" style="height: 50px">
					<div class="col-lg-6">
						<a href="#detail-title" id="{{ $stat->description }}"
							class="{{String::urlize($stat->typ)}}">{{ ucfirst($stat->description) }}</a>
					</div>
					<div class="col-lg-6">
						<div id="chart-{{str_replace(' ', '-', strtolower($stat->description))}}"></div>
					</div>
				  </div>
			  </td>
              <td class="centered">{{ $stat->amount }}</td>
              <td class="centered detailDataTable">{{ $stat->increase }}
				  @if(isset($cmpCrawl))
				  <a href="#detail-title" id="{{$stat->div_id}}_increase_show">Show</a>
				  <a href="#" id="{{$stat->div_id}}_increase_csv">CSV</a>
				  @else
				  NO DATA
				  @endif
			  </td>
              <td class="centered detailDataTable">{{ $stat->decrease }}
				  @if(isset($cmpCrawl))
				  <a href="#detail-title" id="{{$stat->div_id}}_decrease">Show</a>
				  <a href="#" id="{{$stat->div_id}}_increase_csv">CSV</a>
				  @else
				  NO DATA
				  @endif
			  </td>

            </tr>
			@empty
			<tr><td colspan="4">Empty list</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <!-- /.panel-body -->
    </div>
	  
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong id="detail-title" style="font-size: 20px">404</strong>
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
<script type="text/javascript">
	home_url = "{{ URL::route('home') }}";
	crawl_id = '{{ $crawl->id }}';
	cmp_crawl_id = '{{ (isset($cmpCrawl)) ? $cmpCrawl->id : NULL }}';
</script>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/c3.min.js') }}"></script>
<script type="text/javascript">
	home_url = "{{ URL::route('home') }}";
	var start_url = "{{ URL::route('response-codes-urls', [$crawl->id, '404']) }}";
	var oTable = Ajax.detailDataTable(start_url);

	$('.{{String::urlize($stat->typ)}}').on("click", function() {
		var typ = $(this).attr('class').urlize();;
		var description = $(this).attr('id');
		code = description.split(' ')[0];
		
		var url = laroute.route('response-codes-urls', {
			crawl: '{{$crawl->id}}',
			code: description
		});
		console.log(url);

		oTable.fnReloadAjax(home_url + url);
		$('#detail-title').text(description.titlerize());
	});
	
	$('.detailDataTable a').on("click", function() {
		var param = $(this).attr('id').split('_');
		var url = getAddedDetailUrl(param[0], param[1], param[2], param[3]);
		if (param[4] === 'csv') {
			location.href = home_url + url + '?format=csv';
		} else {
			oTable.fnReloadAjax(home_url + url);
		}

		$('#detail-title').text(param[2].titlerize());
	});
	
	var historicStats = {{ json_encode($historicStats) }};
	var charts = new SmallChart();
	charts.drawColumnsList(historicStats);

</script>
@stop