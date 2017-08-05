@if(Auth::check())
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<span class="navbar-brand">
				Logged in
			</span>
			
			<a href="{{ route('home') }}" class="navbar-text">Home</a>
			<a href="{{ route('admin') }}" class="navbar-text">Admin</a>

			<a href="{{ route('logout') }}" class="navbar-text navbar-right">Logout</a>
		</div>
	</nav>
@endif