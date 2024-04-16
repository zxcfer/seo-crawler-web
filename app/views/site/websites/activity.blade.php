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

<div class="row">

  <div class="row">
  	<div class="col-lg-12">
  	<div class="panel panel-default">
      <div class="panel-heading">
        <strong><h4>Activity Log</h4></strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
		<table id="url_alerts" class="table table-striped table-hover">
			<thead>
				<tr>
					<th style="width: 10%;">{{{ Lang::get('website/website.alert') }}}</th>
					<th style="width: 30%;">{{{ Lang::get('website/website.activity') }}}</th>
					<th style="width: 46%;">{{{ Lang::get('website/website.page_url') }}}</th>
					<th style="width: 14%;">{{{ Lang::get('website/website.reported_on') }}}</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
  </div>
</div>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
	var oTable;
	$(document).ready(function() {
		oTable = $('#url_alerts').dataTable( {
			"bProcessing": true,
	        "bServerSide": true,
			"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			},
	        "iDisplayLength": 50,
	        "sAjaxSource": "{{ URL::to('activity-log-data/' . $website->id ) }}",
	        "fnDrawCallback": function ( oSettings ) {
           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
          		$('.dataTables_filter input').addClass('form-control btn-sm');
				$('.dataTables_length select').addClass('form-control btn-sm');
     		}
		});
	});
</script>
@stop
