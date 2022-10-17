<!DOCTYPE html>
<html>
	@admin
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
    </head>
    <center>
		<h2>Security Camera</h2>
	</center>
	<body></body>
	<div class = "container">
		<img src = "camcapture.png"></img>
		<form action = "/snapshot" method = "GET">
			{{ csrf_field() }}
			<button type = "submit">Capture Snapshot</button>
		</form>	
	</div>
	@endadmin
</html>
