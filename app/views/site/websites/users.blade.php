@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3>
				{{{ $title }}}
			</h3>
		</div>
		<!-- Post Content -->
		<table id="website-users" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="col-md-2">{{{ Lang::get('website/website.alert') }}}</th>
					<th class="col-md-2">{{{ Lang::get('website/website.severety') }}}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($alerts as $alert)
				<tr>
					<td>{{{$alert->description}}} </td>
					<td>{{{$alert->severety}}} </td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<hr />
@stop

{{-- Scripts --}}
@section('scripts')
@stop