<!DOCTYPE html>
<html>
	<head>
            <link rel = "stylesheet" href = "../../css/skeleton.css" />
            <link rel = "stylesheet" href = "../../css/style.css" />
    </head>

    <div class = "container">
        <div class = "row">
            <center>
                <h2>Writings</h2>
                <h6>I write about my thoughts every now and then</h6>
                <center> - -- --- ----- -------- ----- --- -- -</center>
                
                @foreach ($writings as $w)
                    <ul style = "list-style-type: none;">
                        <li>
                            <a href = "/verum/{{ $w->id }}"><h2>{{$w->created_at}} -- {{$w->title}}</h2></a>
                            <p>{{substr(strip_tags($w->content), 0, 256) . '...'}}</p>
                        </li>
                    </ul>
                @endforeach
                <center> - -- --- ----- -------- ----- --- -- -</center>
                <br>
        </div>
    </div>

</html>
