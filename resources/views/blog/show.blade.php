
<!DOCTYPE html>
<html>
	<head>
                <link rel = "stylesheet" href = "../../css/skeleton.css" />
                <link rel = "stylesheet" href = "../../css/style.css" />
        </head>

        <div class = "container">
			<div class = "row">
				<center>
					<a href = {{ $w->id }}><h2>{{$w->title}}</h2></a>
                    <div>{{$w->content}}</div>
                    <br>
                    - -- --- ----- --- -- -
                </center>
            </div>
            <div class = "row">
                <center>
                    Comment: <br>
                    <form method = "post" action = "/verum/comments/store">
                        {{ @csrf_field() }}
                        <textarea rows="3" cols="70" name="comment_text"> </textarea><br>
                        Name/Email (optional): <input type = "text" name = "name" /><br>
                        <input type = "text" id = "w_id" name = "w_id" value = "{{htmlspecialchars($w->id)}}" hidden />
                        <button type = "submit" id = "comment_post">Reply</button>
                    </form>
                    <br><br>
                    - -- --- ----- --- -- -
                    @foreach ($comments as $c)
                        <div class = "comment">
                            <small><b>{{ $c->created_at }}</b></small><br>
                            {{ $c->content }} <br>
                            <small>     - {{ $c->name ? $c->name : 'Anonymous'}}</small>
                        </div>
                    @endforeach
                </center>
            </div>
		</div>

</html>
