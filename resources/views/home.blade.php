<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
	</head>
	<center>
		<h2>A Friendly Webserver</h2>
		<h6>in Virginia</h6>
	</center>
	<body></body>
	<div class = "container">
		<div class = "row">
			<div class = "box" width = "70%">
				<script type = "text/javascript">
					const MAX_FILE_SIZE = 512000000; //512 MB


				</script>
				<div id = "file-form">
					<form action = "http://grothe.ddns.net:8090/api/files" method = "POST" enctype="multipart/form-data">
						
						<h4>File Storage</h4>
						<h6>simply upload a file/s (of total size <= 512MB) and be given a link to access it from anywhere (temporary result page is the API json because something broke)</h6>
    					<h6><a href = "f">Uploaded Files</a></h6>
						<input multiple name="f[]" type="file">
						<br>
    					<button type = "submit">Submit</button>
  					</form>
				</div>
			</div>
			<!--
			<div class = "box">
				<a name = "verum"></a>
				<h4>Writings</h4>
				<p>I write thoughts and ideas in the form of a blog essay type of thing. <a href =  "verum">Check it out.</a></p>
			</div>
			-->
			<div class = "box">
				<a name = "pod"></a>
				<h4>Podcast</h4>
				<p>I hosted a few podcasts when living in Ames. <a href =  "podcasts">Check it out.</a></p>
				<!-- <audio controls src = "http://gdev.ddns.net:8899/stream.mp3"></audio> -->
			</div>

			<!--
			<div class = "box">
				<a name = "mc"></a>
				<h4>Minecraft Server</h4>
				<h6>grothe.ddns.net:25565</h6>
			</div>
			-->

			<!--
			<div class = "box">
				<a href = "https://discord.gg/akXYxAR">Discord Server: https://discord.gg/akXYxAR</a>
			</div>
			-->
			<div class = "box">
				<!-- <h5>What's with the "ddns.net" ?</h5>
				<p>ddns.net is a free domain name provided by <a href = "https://noip.com">No-IP</a>. I find it more convenient than always having to type <a href = "http://173.24.176.217">173.24.176.217</a> into the address bar.</p> -->
				<p><h5 style = "display: inline-block;">Questions, concerns, suggesitons?</h5> <a href = "mailto:grothe.tr@gmail.com">Email me</a>.</p>
			</div>

			<center>
			@auth
				<form method="POST" action="{{ route('logout') }}">
						@csrf
					<a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
				</form>
			@else
				<a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Login  </a>
				@if (Route::has('register'))
					<a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">  Register</a>
				@endif
			@endauth
			</center>
		</div>
	</div>

</html>

<?php
        $line = date('Y.m.d-H:i') . " - $_SERVER[REMOTE_ADDR]";
        file_put_contents('access.log', $line . PHP_EOL, FILE_APPEND);
?>
