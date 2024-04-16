@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3>
				{{{ $title }}}
				<div class="pull-right">
					<a href="{{{ URL::to('websites/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
				</div>
			</h3>
		</div>
		<!-- Post Content -->
		<table id="website-users" class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="col-md-2">{{{ Lang::get('website/website.username') }}}</th>
					<th class="col-md-2">{{{ Lang::get('website/website.email') }}}</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<hr />
@stop
{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
				oTable = $('#website-users').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('website-users-data/' . $website->id ) }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
@stop