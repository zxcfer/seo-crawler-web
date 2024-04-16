@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3>
				{{{ $title }}}
				<div class="pull-right">
					<a href="{{{ URL::to('websites/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
				</div>
			</h3>
		</div>
		<!-- Post Content -->
		<table id="website-users" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="col-md-2">URLs</th>
					<th class="col-md-2">Status</th>
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
@stop