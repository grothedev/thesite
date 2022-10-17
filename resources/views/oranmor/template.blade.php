<!DOCTYPE html>
<html lang="en">
	
	<head>
		<link href = "{{{ asset('/css/style.css') }}}" rel = "stylesheet" />
		<link href = "{{{ asset('/css/skeleton.css') }}}" rel = "stylesheet" />
        <title>Oran Mor</title>
	</head>

	<div class = "banner">
		<div class = "banner-title">
			<h1>Oran Mor Community</h1>
		</div>
	</div>

	<div class = "sidebar">
		<div class = "nav-link">
			<ul>
				<li><a href = "/">About</a></li>
				<!-- <li><a href = "/calendar">Calendar</a></li> -->
				<li><a href = "/current">What's happening now</a></li>
				<li><a href = "/shop">Browse our shop</a></li>
				<!--<li><a href = "/discussion">Discussion</a></li> -->
			</ul>
			<br>
			<div id = "user-box">
				@if (Auth::guest())

	                <a href="{{ url('/login') }}" style = "float: left; padding-left: 1.5rem">Login</a>
	                <a href="{{ url('/register') }}" style = "float: right; padding-right: 1.5rem">Register</a>
	            @else
	                
                    <center>{{ Auth::user()->name }}</center>
                   
                        
                    <a href = "{{ url('/u/edit') }} style = "float: left; padding-left: 1.5rem"">
                        Manage User Info
                    </a>
                
            
                
                    <a href="{{ url('/logout') }} style = "float: right; padding-right: 1.5rem""
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                        

	                    
	                
	            @endif
            </div>

		</div>
	</div>

	<div class = "container">
		@yield('container')
	</div>

</html>