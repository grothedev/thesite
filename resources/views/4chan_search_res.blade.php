<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
    </head>
    <center>
		<h2>4chan Search</h2>
		<h6>Result</h6>
	</center>
	<body></body>
	<div class = "container">
		@foreach($res as $url)
		<div class = "row">
			<a href = "{{ $url }}">{{ $url }}</a>
		</div>
		@endforeach
    	</div>
</html>
