<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
	</head>
	<center>
		<h2>A Friendly Webserver</h2>
	</center>
	<body></body>
	<div class = "container">
		<div class = "row">
			<div class = "box" width = "70%">
				<script type = "text/javascript">
					const MAX_FILE_SIZE = 512000000; //512 MB

					function checkFileSize(){
						var input = document.getElementById("fileInput");

						if (!input){
							alert("couldn't get file input");
							return;
						} else if (!input.files){
							alert("browser does not support files :( ");
							return;
						}

						console.log(input);
						console.log(input.length);
						var i;
						for (i = 0; i < input.files.length; i++){

							if (input.files[i].size > MAX_FILE_SIZE) {
								document.getElementById("submitBtn").disabled = true;
								console.log("too big file. must be less than this many bytes: " + MAX_FILE_SIZE );
								return;
							}
							console.log("ok size file " + input.files[i].size);
						}

						document.getElementById("submitBtn").disabled = false;
					}
				</script>
				<div id = "file-form">
					<form action = "file-upload.php" method = "post" enctype="multipart/form-data" multiple = "multiple">
						<h4>File Storage</h4>
						<h6>simply upload a file and be given a link to access it from anywhere</h6>
						<input name = "upload[]" type = "file" multiple onchange = "checkFileSize()" id = "fileInput" /><br>
						<input type = "submit" value = "Upload File/s" id = "submitBtn" disabled />
					</form>
					<a href = "f"><h4>See all files</h4></a>
				</div>
			</div>

			<div class = "box">
				<a name = "pod"></a>
				<h4>Podcast</h4>
				<p>I host podcasts every week or so. <a href =  "pod">Check it out.</a></p>
				<audio controls src = "http://gdev.ddns.net:8899/stream.mp3"></audio>
			</div>

			<div class = "box">
				<a href = "https://discord.gg/akXYxAR">Discord Server: https://discord.gg/akXYxAR</a>
			</div>

			<div class = "box">
				<p>Questions, concerns, suggesitons? <a href = "mailto:grothe.tr@gmail.com">Email me</a>.</p>
			</div>

		</div>
	</div>

</html>

<?php
        $line = date('Y.m.d-H:i') . " - $_SERVER[REMOTE_ADDR]";
        file_put_contents('access.log', $line . PHP_EOL, FILE_APPEND);
?>
