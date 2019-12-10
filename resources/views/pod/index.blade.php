
<!DOCTYPE html>
<html>
	<head>
                <link rel = "stylesheet" href = "../../css/skeleton.css" />
                <link rel = "stylesheet" href = "../../css/style.css" />
        </head>

        <div class = "container">
			<div class = "row">
				<center>
					<h2>A Podcast (to be named)</h2>
					<h6>This is a podcast hosted in Ames, IA, where anything of concern or interest is discussed</h6>

					<audio controls src = "http://gdev.ddns.net:8899/stream.mp3"></audio>
					<br>
					<p font-size  = "3px"><a href = "http://gdev.ddns.net:8899/stream.mp3">Direct link to stream</a></p>
					<br>
					<center> - -- --- ----- -------- ----- --- -- -</center>
					<h5>Previous episodes</h5>
					@foreach ($pods as $pod)
						<ul style = "list-style-type: none;">
							<li>
								<a href = "f/{{ $pod->filename }}"><h2>{{$pod->day}}</h2></a>
								<p>{{$pod->description}}</p>
								<p>Participants: {{$pod->people }}</p>
							</li>
						</ul>
					@endforeach
					<center> - -- --- ----- -------- ----- --- -- -</center>
					<br>
					<p>
						If you would like to talk on the podcast, <a href = "form.php">fill out this form.</a> (under construction currently. send me an email for the time being)
					</p>

			</div>
		</div>

</html>
