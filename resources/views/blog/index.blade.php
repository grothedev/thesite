<!DOCTYPE html>
<html>
	<head>
            <link rel = "stylesheet" href = "../../css/skeleton.css" />
            <link rel = "stylesheet" href = "../../css/style.css" />
    </head>
<?php use Carbon\Carbon; ?>
    <div class = "container">
        <div class = "row">
            <center>
                <h2>Writings</h2>
                <h6>I write about my thoughts every now and then</h6>
                <center> - -- --- ----- -------- ----- --- -- -</center>
            </center>
                @foreach ($writings as $w)
                    <div class = "box writing-listitem">
                        <center>
                            <a href = "/verum/{{ $w->id }}"><h3>{{$w->title}}</h3></a>
                            <h6>{{(new Carbon($w->created_at))->toFormattedDateString() }}</h6>
                        </center>
                        <p>{!! html_entity_decode(substr($w->content, 0, 256)) . '...' !!}</p>
                    </div>
                @endforeach
                <center> - -- --- ----- -------- ----- --- -- -</center>
                <br>
        </div>
    </div>

</html>
