<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
	</head>
	<center>
		<h3>Minecraft Server Admin</h3>
		<h6>Restart the server if it is laggy</h6>
	</center>
	<body></body>
	<div class = "container">
		<div class = "row">
			<div class = "box" width = "70%">
                {{ Form::open( array('action' => 'SiteController@restartMCServer', 'method' => 'get') ) }}
                    MC Admin Password: <input type = "password" name = "password" /><br>
                    <button type = "submit">Restart Server</button><br>
                    <input type = "hidden" name = "restart" value = "1" />
                {{ Form::close() }}
            </div>
        </div>
    </div>
</html>