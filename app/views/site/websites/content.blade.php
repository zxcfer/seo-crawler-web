@extends('site.layouts.default')

@section('styles')
@stop 

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3>
		{{{ $title }}}
	</h3>
    <small>Crawl date: {{ $crawl->worked_on }}</small>
</div>
@foreach($groups as $group_title => $ids )
<div class="row">
  <!-- /.col-lg-6 -->
  	<div class="col-lg-12">
  	<div class="panel panel-default">
      <div class="panel-heading">
        <strong>{{ $group_title }}</strong>
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="serptable">
          <thead>
            <tr>
              <th>Alert</th>
              <th>Amount</th>
              <th>Added since<br />
              {{ $previous_crawl->worked_on }}
              </th>
              <th>Removed since<br />
              {{ $previous_crawl->worked_on }}</th>
            </tr>
          </thead>
          <tbody id="list_tbody">
            @foreach($ids as $id)
            <tr>
              <td>{{ $content_now[$id]->description }}</td>
              <td>{{ $content_now[$id]->amount }}</td>
              <td>+{{ ($content_now[$id]->amount > $content_previous[$id]->amount ) ?
                $content_now[$id]->amount - $content_previous[$id]->amount : 0 }}</td>
              <td>-{{ ($content_previous[$id]->amount > $content_now[$id]->amount ) ?
                $content_previous[$id]->amount - $content_now[$id]->amount : 0 }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
</div>
@endforeach

@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/c3.min.js') }}"></script>


@stop