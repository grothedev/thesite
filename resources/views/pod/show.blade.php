
<!DOCTYPE html>
<html>
	<head>
                <link rel = "stylesheet" href = "../../css/skeleton.css" />
                <link rel = "stylesheet" href = "../../css/style.css" />
        </head>

        <div class = "container">
			<div class = "row">
				<center>
					<a href = {{ $pod->filename }}><h2>$pod->timestamps</h2></a>
					<p>$pod->description</p>
					<p>Participants: $pod->people </p>
				</center>
			</div>
		</div>

</html>
