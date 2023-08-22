<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
		<script type = "module" src = "js/util.js"></script>
		<script src = "https://unpkg.com/vue@3"></script>
		<script src = "https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<script type="module">
			import App from "./js/App.js";
			Vue.createApp(App, {
				env: @json(App\Http\Controllers\SiteController::env()),
			}).mount('#app');
		</script>
	</head>
	<center>
		<h2>A Friendly Webserver</h2>
		<h6>in Iowa</h6>
	</center>
	<body></body>
	<div id = "app" class = "container">
		<div class = "row">
			<div class = "box" width = "70%">
				<script type = "text/javascript">
					const MAX_FILE_SIZE = 10240000000   //512000000; //512 MB

				</script>
				<h4>File Storage</h4>
				<h6><a href = "f">Browse Uploaded Files</a></h6>
				<div id = "file-form-old" class = "section">
					<h5>Standard File Upload</h5>
					<form action = "{{ env('FILEUPLOAD_URL') }}" method = "POST" enctype="multipart/form-data">
						<h6>simply upload a file/s (of total size <= 512MB) and be given a link to access it from anywhere</h6>
						<input multiple name="f[]" type="file">
						<input hidden="true" name="htmlresponse" value="1" />
						<br>
						<button type = "submit">Submit</button>
					</form>
				</div>
				<div id = "file-form" class = "section">
					<h5>Chunked File Upload (Javascript) -- Out of Order. Under Construction.</h5>
					<h6>use this if you are uploading large files</h6>
					<div id = "yesscript">
						<input id = "f" multiple name="f[]" type="file" v-on:change="prepareFileInput" >
						<br>
						<!-- <button enabled="false" type = "submit" v-on:click = "uploadFile">Upload</button> -->
						<button enabled="false" type = "submit" onclick = "alert('currently not available! sorry!')">Upload</button>
						<br>
						<!--<p>Chunked uploading may or may not be working, as it is currently under construction. Also the frontend is still under construction, so you're better off checking the dev console to see if a file upload was successful.</p> -->
						<upload-status :files="uploadState.files">

						</upload-status>
						<p>@{{progressText}}</p>
					</div>
					<div id = "hashtest" style="display:hidden;">
						<input type = "text" v-on:input = "testhash" name = "hashInput" />
					</div>
				</div>
			</div>
			<div class = "box">
				<a name = "lemmy"></a>
				<h4>Lemmy</h4>
				<p>I started hosting a Lemmy instance in August of 2023, on port 7373 of this server. <a href = "http://goob.ddns.net:7373">Check it out.</a></p>
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
				<p>I did a few podcasts with some friends a while back. <a href =  "podcasts">Check it out.</a></p>
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
			<!--
			<div class = "box"> TODO comment box
				<p><h5 style = "display: inline-block;">Questions, concerns, suggesitons?</h5>
			</div>-->

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
