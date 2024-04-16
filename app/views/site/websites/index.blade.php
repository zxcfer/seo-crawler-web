@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3>
				{{{ $title }}}
				<div class="pull-right">
					<a id="create-website-btn" href="#" class="btn btn-small btn-info">
						<span class="glyphicon glyphicon-plus-sign"></span> Create</a>
				</div>
			</h3>
		</div>
		<!-- Post Content -->
		<table id="websites" class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="col-md-3">Website</th>
					<th class="col-md-2">URL</th>
					<th class="col-md-2">Last Crawl</th>
					<th class="col-md-2">Total Crawls</th>
					<th class="col-md-1">Actions</th>
                </tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<hr />
@stop
{{-- Scripts --}}
@section('scripts')
<script id="create-website" type="text/x-handlebars-template">
<form id="website-create" class="form-horizontal" method="post" 
		action="{{ URL::route('website_create') }}" autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="tab-content">
		<div class="tab-pane active" id="tab-general">
			<div class="form-group">
				<label class="col-md-4 control-label" for="name">Website Name</label>
				<div class="col-md-8">
					<input class="form-control" type="hidden" name="website_id" id="website_id"/>
					<input class="form-control" type="text" name="name" id="name"/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="url">URL</label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="url" id="url"/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="name">Website Name</label>
				<div class="col-md-4">
					{{ Form::select('max_urls', 
					Website::$max_urls_choices, null, 
					array('class' => 'form-control', 'id' => 'max_urls')) }}
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label" for="name">Website Name</label>
				<div class="col-md-4">
					{{ Form::select('schedule', 
					Website::$schedule_choices, null, 
					array('class' => 'form-control', 'id' => 'schedule')) }}
				</div>
			</div>

		</div>
	</div>
</form>
</script>
<script type="text/javascript">
if (typeof htmlCreateForm === 'undefined') {
	var source = $("#create-website").html();
	var template = Handlebars.compile(source);
	var context = {title: "New Website", body: ""};
	htmlCreateForm = template(context);
}

validForm = false;
setFormValidator = function() {
	createFormValidator = $('#website-create').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            url: { validators: { 
				uri: { message: 'The avatar URL is not valid' },
				notEmpty: { message: 'The full name is required' } } 
			},
			name: { validators: { notEmpty: { message: 'The full name is required' } } }
        },
		onSuccess: function(e) { validForm = true; console.log('TRUE valid');},
		onError: function(e) { validForm = false; console.log('FALSE valid');}
    });
};

postForm = function() {
	$('#website-create').data('formValidation').validate();
	if (validForm) {
		console.log('valid');
		Ajax.postForm("#website-create", function (data, status) {
			oTable.fnReloadAjax();
			$.notify(
				{title: "New website has been created:", message: ""},
				{placement: {from: "top",align: "center"}}
			);
		});
	} else {
		console.log('invalid');
		return false;
	}
};

var create_edit_modal = {
	title: "Create new Website",
	message: htmlCreateForm,
	buttons: {
		success: {
			label: "Save",
			className: "btn-success",
			callback: postForm
		},
		danger: {
			label: "Cancel",
			className: "btn-danger",
			callback: function() {
				console.log('clossing modal');
			}
		}
	}
};

$("#create-website-btn").on("click", function(e) {
	var box = bootbox.dialog(create_edit_modal);
	box.on("shown.bs.modal", function() {
		setFormValidator();
	});
});

var on_edit = function(e) {
	full_id = $(this).attr('id').split('__');
	console.log(full_id);
	
	var box = bootbox.dialog(create_edit_modal);	
	box.on("shown.bs.modal", function() {
		$('#website_id').val(full_id[1]);
		$('#name').val(full_id[2]);
		$('#url').val(full_id[0]);
		$('#max_urls').val(full_id[3]);
		$('#schedule').val(full_id[4]);
		setFormValidator();
	});
};

var on_delete = function(e) {
	var full_id = $(this).attr('id').split('-');
	var website_id = full_id[1];
	var name = "<strong>"+full_id[2]+"</strong>";

	bootbox.confirm('Do you really want to delete '+name+' website?', function(result) {
		if (result) {
			var url = "{{ URL::route('website_delete') }}".replace('%7Bwebsite_id%7D', website_id);
			var data = {_token: '{{{ csrf_token() }}}'};
			Ajax.post(url, data, function (data, status) {
				oTable.fnReloadAjax();
				$.notify(
					{title: "Website has been deleted", message: ""},
					{type: 'success', placement: {from: "top",align: "center"}}
				);
			});
		} else {
			$.notify(
				{title: "Website has not been deleted", message: ""},
				{type: 'danger', placement: {from: "top",align: "center"}}
			);
		}
	});
};

var oTable;
$(document).ready(function() {
	oTable = $('#websites').dataTable({
		"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": { "sLengthMenu": "_MENU_ websites per page" },
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "{{ URL::to('websites_data' ) }}",
		"fnDrawCallback": function () {
			$(".iframe").colorbox({iframe:true, width:"60%", height:"80%"});
			$('.dataTables_filter input').addClass('form-control btn-sm');
			$('.dataTables_length select').addClass('form-control btn-sm');
			$(".delete").on("click", on_delete);
			$(".edit").on("click", on_edit);
		}
	});
});
</script>
@stop