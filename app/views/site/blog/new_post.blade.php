@extends('site.layouts.default')

{{-- Content --}}
@section('content')

	{{-- Edit Blog Form --}}
	<h2>Job Post</h2>
	<form id="newform" class="form-horizontal" method="post" action="@if (isset($post)){{ URL::to('admin/blogs/' . $post->id . '/edit') }}@endif" autocomplete="off">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Position</label>
						<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($post) ? $post->title : null) }}}" />
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ post title -->

				<!-- Post Location -->
				<div class="form-group form-inline {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-2">
                        <label class="control-label" for="location">Location</label>
					</div>
                    <div class="col-md-3">
                    	{{ Form::text('location', Input::old('title', isset($post) ? $post->title : null), array('class' => 'form-control')) }}
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
                    <div class="col-md-2">
                        <label class="control-label" for="category">Salario</label>
					</div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="price" id="price" value="{{{ Input::old('title', isset($post) ? $post->title : null) }}}" />
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
					
				</div>
				<!-- ./ post location -->
				
				<div class="form-group form-inline {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-2">
						<label class="control-label" for="type">Type</label>
					</div>
                    <div class="col-md-3">
                    	{{ Form::select('type', $types, 'FT', array('class' => 'form-control'))}}
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>

					<div class="col-md-2">
						<label class="control-label" for="category">Category</label>
					</div>
                    <div class="col-md-3">
                        {{ Form::select('category', $categories, 'FT', array('class' => 'form-control'))}}
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
				</div>
		
				<!-- Contact EMail -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="email">Contact Email</label>
						{{ Form::text('email', Input::old('email', isset($post) ? $post->email : null), array('class' => 'form-control')) }}
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ contact email -->
				
				<!-- Content -->
				<div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="content">Content</label>
						<textarea class="form-control full-width wysihtml5" name="content" id="content" rows="10">{{{ Input::old('content', isset($post) ? $post->content : null) }}}</textarea>
						{{ $errors->first('content', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ content -->
				
	<h2>Company</h2>
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li><a href="#tab-meta-data" data-toggle="tab">Details</a></li>
		</ul>
	<!-- ./ tabs -->

				
		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				
				<!-- company-name -->
				<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Name</label>
						<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($post) ? $company->name : null) }}}" />
						{{ $errors->first('name', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ company-name -->
				
			</div>
			<!-- ./ general tab -->
			
			<!-- Details tab -->
			<div class="tab-pane" id="tab-meta-data">
			<!-- Sitio Web -->
				<div class="form-group {{{ $errors->has('website') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="website">Sitio Web</label>
						<input class="form-control" type="text" name="website" id="website" value="{{{ Input::old('website', isset($post) ? $post->website : null) }}}" />
						{{ $errors->first('website', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ categoria -->
				
				<!-- Correo -->
				<div class="form-group {{{ $errors->has('category') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Categoria</label>
						<input class="form-control" type="text" name="category" id="category" value="{{{ Input::old('category', isset($post) ? $post->title : null) }}}" />
						{{ $errors->first('category', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ categoria -->
				
				<!-- Descripcion -->
				<div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="content">Descripci&oacute;n</label>
						<textarea class="form-control full-width wysihtml5" name="description" value="description" rows="10">{{{ Input::old('description', isset($post) ? $post->description: null) }}}</textarea>
						{{ $errors->first('description', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ content -->

			</div>
			<!-- ./ meta data tab -->
		</div>
		<!-- ./ tabs content -->

		<!-- Form Actions -->
		<div class="form-group">
			{{ Form::captcha(array('theme' => 'blackglass')); }}
			<div class="col-md-12">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop

{{-- Content --}}
@section('scripts')
    <script>
    $(document).ready(function() {
        $('#newform').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                content: {
                    validators: {
                        notEmpty: {
                            message: 'The content is required'
                        },                        
                        stringLength: {
                            message: 'Post content must be less than 120 characters',
                            min: 120
                        }                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The email address is required'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        }
                    }
                },
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The email address is required'
                        }
                    }
                },
                price: {
                    validators: {
                        notEmpty: {
                            message: 'The price is required'
                        },
                        numeric: {
                            message: 'The price must be a number'
                        }
                    }
                },
                title: {
                    validators: {
                        notEmpty: {
                            message: 'The amount is required'
                        }
                    }
                }
            }
        });
    });
    </script>
@stop
