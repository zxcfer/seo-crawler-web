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
		<a href="?format=csv" id="csv-button" class="btn btn-large pull-right">
			CSV<span class="glyphicon glyphicon-download-alt"></span></a>
      </div>
      
      <div class="panel-body">
	    <table class="table table-striped table-bordered table-hover dataTable no-footer no-padding" id="serptable">
          <thead>
            <tr>
              <th class="centered">Path</th>
              <th>Type</th>
              <th>Errors</th>
			  <th>Warnings</th>
			  <th>Last submitted</th>
            </tr>
          </thead>
          <tbody id="list_tbody">
			@forelse($gwtDump->sitemaps as $sitemap)
            <tr>
			  <td><a href="{{$sitemap->path}}">{{$sitemap->path}}</a></td>
              <td class="centered">{{ $sitemap->type }}</td>
              <td class="centered">{{ $sitemap->errors }}</td>
              <td class="centered">{{ $sitemap->warnings }}</td>
              <td class="centered">{{ $sitemap->last_submitted }}</td>
            </tr>
			@empty
			<tr><td colspan="4">Empty list</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <!-- /.panel-body -->
    </div>
  </div>
</div>
@stop
