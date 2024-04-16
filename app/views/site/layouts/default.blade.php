<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>@section('title') 
			SEO Spider 
			@show</title>
		@section('meta_keywords')
		<meta name="keywords" content="your, awesome, keywords, here" />
		@show
		@section('meta_author')
		<meta name="author" content="Jon Doe" />
		@show
		@section('meta_description')
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />
		@show

		<link rel="stylesheet" href="{{asset('bootstrap-3.3.5-dist/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/formValidation.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/default.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/colorbox.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap-treeview.css')}}">
        <link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>
        @yield('css')
		
		<style>
        body { padding: 60px 0; }
		@section('styles')
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	</head>

	<body>
		<!-- To make sticky footer need to wrap in a div -->
		<div id="wrap" class="">
		@include('header_navbar')

		<!-- Container -->
		<div class="container">

			<div class="row">

				<!-- sidebar -->
				@if (Auth::check())
					
					@unless  ( Request::is('search') || Request::is('/') )
					<div class="col-md-12">
						@include('menu-sidebar')
					</div>
					@endunless
					
				@endif
				<!-- ./ sidebar -->
			</div>
			<div class="row">
				<div class="col-md-12">
				<!-- Notifications -->
				@include('notifications')
				<!-- ./ notifications -->

				<!-- Content -->
				@yield('content')
				<!-- ./ content -->
				</div>
			</div>
		</div>
		<!-- ./ container -->

		<!-- the following div is needed to make a sticky footer -->
		<div id="push"></div>
		</div>
		<!-- ./wrap -->

		<!-- Footer -->
		<footer class="text-center">
			<div class="footer-below">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							Copyright &copy; Your Website 2014
						</div>
					</div>
				</div>
			</div>
		</footer>

        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="{{asset('assets/js/moment.min.js')}}"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
		<script src="//cdn.datatables.net/plug-ins/1.10.7/api/fnReloadAjax.js"></script>
		<script src="{{asset('bootstrap-3.3.5-dist/js/bootstrap.js')}}"></script>
        <script src="{{asset('assets/js/datatables-bootstrap.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap-datepicker.js')}}"></script>
		<script src="{{asset('assets/js/bootbox.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap-notify.min.js')}}"></script>
		<script src="{{asset('assets/js/handlebars-v3.0.0.js')}}"></script>
        <script src="{{asset('assets/js/jquery.colorbox.js')}}"></script>
        <script src="{{asset('assets/js/formValidation.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap-formValidation.min.js')}}"></script>
		<script src="{{asset('assets/js/bootstrap-treeview.js')}}"></script>
		<script src="{{asset('assets/js/laroute.js')}}"></script>

		<script src="{{asset('assets/js/app.js')}}"></script>
        @yield('scripts')
	</body>
</html>
