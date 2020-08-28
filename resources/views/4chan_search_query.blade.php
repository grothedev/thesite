<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
    </head>
    <center>
		<h2>4chan Search</h2>
		<h6>Query</h6>
	</center>
	<body></body>
	<div class = "container">
		<div class = "row">
			<div class = "box" width = "70%">
                <form action = "/4" method="POST">
                    Keyword
                    <input type = "text" name = "q" /><br>
                    Board (Optional)
                    <input type = "text" name = "b" /><br>
                    <button type = "submit">Submit Query</button>
                </form>
            </div>
        </div>
    </div>
</html>