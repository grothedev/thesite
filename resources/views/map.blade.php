<!DOCTYPE html>
<!--  -->
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
        <link rel = "stylesheet" href = "css/style.css" />
        <link rel="stylesheet" href="https://js.arcgis.com/3.30/esri/css/esri.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://js.arcgis.com/3.30/"></script>
        <script type = "text/javascript" src = "js/main.js"></script>
	</head>
	<center>
		<h2>Prototype for Geographic Applications</h2>
	</center>
	<body></body>
	<div class = "container">
		<div class = "row" >
            <div id = "map"></div>
        </div>
        <div class = "infowindow">
        </div>
        <div class = "row">
            {{ Form::open(  ) }}
                <h2>What are you looking for?</h2>
                Node Type {{ Form::select('nodetype') }} (e.g. Recycling Deposit, Garden, Tool Library)<br> <!-- populate with node types from API -->
                Keyword {{ Form::text('keyword') }}<br> <!-- searches for nodes of any/some type with any attr having keyword -->
                {{ Form::submit('this button should be unnecessary and just be a loading icon for async action') }}
            {{ Form::close() }}
        </div>
    </div>
</html>