<!DOCTYPE html>
<html>
	<head>
		<link rel = "stylesheet" href = "css/skeleton.css" />
		<link rel = "stylesheet" href = "css/style.css" />
	</head>
	<center>
		<h3>Image Dump - summer bafoon 2021</h3>
	</center>
	<body></body>
	<div class = "container">
		<div class = "row">
			<div class = "box" width = "90%">
                <h6>Upload some pictures</h6>
                {{ csrf_field() }}
                <form method = "POST" action = "{{ env('FILES_API_URL') }}" files = "true" enctype="multipart/form-data" >
                    <input type = "file" name = "f" multiple />
                    <br>
                    <input type = "text" name = "tag" value = "sheeshbb" hidden />
                    <small>For now after you upload just hit back button then refresh</small><br>
                    <button type = "submit">Submit</button>
                    ToDo: automatically redirect to this page
                </form>
            </div>
            <br>
            ToDo: add link to download all or some selection
        </div>
        <div class = "row">
            <div class = "box" width = "90%">
            <?php
                $client = new GuzzleHttp\Client(['base_uri' => 'http://grothe.ddns.net:8090']);
                $resp = $client->request('GET', '/api/files?tag=sheeshbb');
                $images = json_decode($resp->getBody());
            ?>
                @foreach ($images as $img)
                        <div class = "img-li">
                        <a href = "http://grothe.ddns.net:8090/f/{{ $img->filename }}">
                            @if (strstr(strtolower($img->filename), '.jpg') || strstr(strtolower($img->filename), '.png') || strstr(strtolower($img->filename), '.jpeg'))
				<img class="img-li" src = "http://grothe.ddns.net:8090/f/{{ $img->filename }}"></img><br>
			    @else
				<p>{{ $img->filename }}</p>
			    @endif
                        </a>
</div>
                @endforeach
                <br>
                <a href = "http://grothe.ddns.net:8090/api/files?tag=sheeshbb">JSON array of these images</a>
            </div>
        </div>
    </div>
</html>
