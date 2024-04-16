<div class="sidebar-nav" style="padding: 20px 0px 0px 0px; width: 100%;">
	<ul class="nav nav-list" style="padding: 0px;">
		<li class="nav-header"><h3>Palabras clave</h3></li>
		<li>
			{{ Form::open( array( 'url'=>'search', 'method'=>'get', 'id'=>'search' ) ) }}
				<div class="form-group">
					<input class="form-control" name="keyword" id="keyword" maxlength="50" type="text" value="{{{Input::old('keyword')}}}" placeholder="Search Keyword">
				</div>
				<div class="form-group" role="group">
					{{ Form::select('region', $regions, Input::old('region_id'), array('class' => 'form-control'))}}
				</div>
				<div class="form-group text-right">
					<input type="submit" value="Search" class="btn btn-large btn-success">
				</div>
				{{ Form::hidden('age', $value = Input::old('age')) }}
				{{ Form::hidden('type', $value = Input::old('type')) }}
				{{ Form::hidden('category', $value = Input::old('category')) }}
			{{ Form::close() }}
				
			<div class="well">
				<h4>Antiguedad</h4>
				<div class="btn-group-vertical" role="group">				
					<a href="#" onclick="return searchByAge('{{ (Input::get('age')=='last24') ? '' : 'last24' }}')" 
							class="btn btn-default {{ (Input::get('age')=='last24') ? 'active' : '' }}">Last 24 hrs
						<span class="glyphicon glyphicon-{{ (Input::get('age')=='last24') ? 'remove red' : 'search' }} pull-right" ></span></a>
					<a href="#" onclick="return searchByAge('{{ (Input::get('age')=='lastweek') ? '' : 'lastweek' }}')" 
							class="btn btn-default {{ (Input::get('age')=='lastweek') ? 'active' : '' }}">Last week
						<span class="glyphicon glyphicon-{{ (Input::get('age')=='lastweek') ? 'remove red' : 'search' }} pull-right"></span></a>
					<a href="#" onclick="return searchByAge('{{ (Input::get('age')=='lastmonth') ? '' : 'lastmonth' }}')" 
							class="btn btn-default {{ (Input::get('age')=='lastmonth') ? 'active' : '' }}">Last month
						<span class="glyphicon glyphicon-{{ (Input::get('age')=='lastmonth') ? 'remove red' : 'search' }} pull-right"></span></a>
				</div>
			
				<h4>Category</h4>
				<div class="btn-group-vertical" role="group">
					@foreach ($categories as $key => $category)
					<a href="#" onclick="return searchByCat('{{{ (Input::get('category')==$key) ? '' : $key }}}')" 
						class="btn btn-default {{ (Input::get('category')==$key) ? 'active' : '' }}">
						{{ $category }}<span class="glyphicon glyphicon-{{ (Input::get('category')==$key) ? 'remove red' : 'search' }} pull-right" aria-hidden="true"></span></a>
					@endforeach
				</div>
				
				<h4>Type</h4>
				<div class="btn-group-vertical" role="group">
					@foreach ($types as $key => $type)
					<a href="#" onclick="return searchByType('{{{ $key }}}')" class="btn btn-default">
						{{ $type }}<span class="glyphicon glyphicon-search pull-right" aria-hidden="true"></span></a>
					@endforeach
				</div>
				
			</div>
		</li>
		<li class="nav-header"><h3> Favorites </h3></li>
		<li> <a href="http://dev.binacube.com:8086/profile/1/">Saint Peter Retirement Home</a> </li>
		<li> <a href="http://dev.binacube.com:8086/profile/1/">Saint Peter Retirement Home</a> </li>
		<li> <a href="http://dev.binacube.com:8086/profile/1/">Saint Peter Retirement Home</a> </li>
		<li> <a href="http://dev.binacube.com:8086/profile/3/">Zeppelin Retirement Home</a> </li>
	</ul>
</div>

<script type="text/javascript">
function searchByAge(value) {
	$("input[name='age']").val(value);
	$('form#search').submit();
	return false;
}

function searchByType(value) {
	$("input[name='category']").val(value);
	$('form#search').submit();
	return false;
}

function searchByCat(value) {
	$("input[name='category']").val(value);
	$('form#search').submit();
	return false;
}
</script> 
