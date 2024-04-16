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

@foreach($groups as $group_title => $group)
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
            @foreach($group as $item_title => $item)
            <tr>
              <td>{{ $item_title }}</td>
              <td>{{ $item['amount'] }}</td>
              <td>+{{ ($item['amount'] > $item['previous_amount'] ) ?
                $item['amount'] - $item['previous_amount'] : 0 }}</td>
              <td>-{{ ( $item['previous_amount'] > $item['amount'] ) ?
                $item['previous_amount'] - $item['amount'] : 0 }}</td>
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