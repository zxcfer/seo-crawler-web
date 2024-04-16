<!-- Navbar -->
<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
	 <div class="container" style="margin-top: 10px;">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">Home</a></li>
				@if (Auth::check())
				<li {{ (Request::is('websites') ? ' class="active"' : '') }}><a href="{{{ URL::to('websites') }}}">Websites</a></li>
				@endif
			</ul>

			<ul class="nav navbar-nav pull-right">
				@if (Auth::check())
				@if (Auth::user()->hasRole('admin'))
				<li><a href="{{{ URL::to('admin') }}}">Admin Panel</a></li>
				@endif

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}} <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{{ URL::to('user/profile/'.Auth::user()->username ) }}}"> Profile</a></li>
						<li><a href="{{{ URL::to('user') }}}"> Edit Profile</a></li>
					</ul>
				</li>
				<li><a href="{{{ URL::to('user/logout') }}}">Logout</a></li>
				@else
				<li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">Login</a></li>
				<li {{ (Request::is('user/create') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
				@endif
			</ul>
			<!-- ./ nav-collapse -->
		</div>
	</div>
</div>
<!-- ./ navbar -->