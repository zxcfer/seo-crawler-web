@extends('site.layouts.modal')

{{-- Content --}}
@section('content')

	<form class="form-horizontal" method="post" action="{{ $form_url }}" autocomplete="off">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="_method" value="{{ $method }}" />

		<div class="tab-content">
			<div class="tab-pane active" id="tab-general">
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="name">Website Name</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($website->name) ? $website->name : null) }}}" />
						{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('url') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="url">URL</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="url" id="url" value="{{{ Input::old('url', isset($website->url) ? $website->url : null) }}}" />
						{{ $errors->first('url', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="submit" class="btn btn-success">OK</button>
			</div>
		</div>
	</form>
@stop
