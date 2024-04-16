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

    <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Web Crawl</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
  
</div>

<div class="row">
  <!-- /.col-lg-6 -->

    <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Sitemaps</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
  
</div>

<div class="row">
  <!-- /.col-lg-6 -->

    <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>Analytics</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
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


@stop