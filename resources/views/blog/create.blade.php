<form role="form" method="POST" action="{{ ('/verum/store') }}">
{{csrf_field()}}
<div class="form-group{{ $errors->has("id") ? " has-error" : ""}}">
<label for = "id" class = "col-me-2 control-label">id</label>
<input type = "text" id = "id" class = "form-control" name = "id" value="{{ old( "id")}}" autofocus></input>
</div><div class="form-group{{ $errors->has("title") ? " has-error" : ""}}">
<label for = "title" class = "col-me-2 control-label">title</label>
<input type = "text" id = "title" class = "form-control" name = "title" value="{{ old( "title")}}" autofocus></input>
</div><div class="form-group{{ $errors->has("content") ? " has-error" : ""}}">
<label for = "content" class = "col-me-2 control-label">content</label>
<input type = "text" id = "content" class = "form-control" name = "content" value="{{ old( "content")}}" autofocus></input>
</div>
<label for = "day" class = "col-me-2 control-label">day</label>
<input type = "date" id = "day" class = "form-control" name = "day" value="{{ old( "day")}}" autofocus></input>
</div>
<div class="form-group">
<div class="col-md-8 col-md-offset-2">
password: <input type = "password" name = "password" />
<button type="submit">Submit</button>
</div></div></form>
