<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
	</head>
	<center>
		<h3>Image Viewer</h3>
	</center>
	<body></body>
        <div class = "row">
            <div class = "box" width = "90%">
            <?php
                //$client = new GuzzleHttp\Client(['base_uri' => 'http://grothe.ddns.net:8090']);
                //$resp = $client->request('GET', '/api/files?tag='.$imgtag);
                //$images = json_decode($resp->getBody());
            ?>
                @foreach (array_diff(scandir($imgdir), ['.','..']) as $imgfile)
			@if ( $slow == true)
				<a href = "{{ $imgdir . '/' . $imgfile }}">{{ $imgfile }}</a><br>
			@else 
				@if (strstr(mime_content_type($imgdir . '/' . $imgfile), "image/")) 
					<a href = "{{ $imgdir . '/' . $imgfile }}"><img width = "20%" height = "auto" style = "display:inline-block;" src="{{ $imgdir . '/' . $imgfile }}" /></a>
				@elseif (strstr(mime_content_type($imgdir . '/' . $imgfile), "video/")) 
					<video controls width = "45%" height = "auto" style = "display:inline-block;"> <source src="{{ $imgdir . '/' . $imgfile }}"> </video>
				@endif
			@endif
		@endforeach
		<br>
            </div>
        </div>
    </div>
</html>
