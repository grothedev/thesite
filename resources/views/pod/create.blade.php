<!--
	this file is to manage a currently running podcast. it will require authentication
-->

<!DOCTYPE html>
<html>
	<head>
                <link rel = "stylesheet" href = "../../css/skeleton.css" />
                <link rel = "stylesheet" href = "../../css/style.css" />
        </head>



        <div class = "container">
			<div class = "row">
				<center>
					<h2>Create a new Podcast Episode</h2>

					<form class="form-horizontal" role="form" method="POST" action="{{ action('PodcastController@store') }}" files = "true" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

			                <label for="name" class="col-md-2 control-label">Participants</label>



			                    <input type = "text" id="people" class="form-control" name="people" value="{{ old('people') }}" required autofocus></input>

			                    @if ($errors->has('people'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('people') }}</strong>
			                        </span>
			                    @endif

			            </div>

			            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

			                <label for="description" class="col-md-2 control-label">Description</label>



			                    <textarea id="description" class="form-control" name="description" value="{{ old('description') }}" cols = "50" required autofocus></textarea>

			                    @if ($errors->has('description'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('description') }}</strong>
			                        </span>
			                    @endif

			            </div>

			            <div class="form-group{{ $errors->has('f') ? ' has-error' : '' }}">

			                <label for="f" class="col-md-2 control-label">Recording</label>

			                    <input type = "file" id="f" class="form-control" name="f" value="{{ old('f') }}" autofocus />

			                    @if ($errors->has('f'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('f') }}</strong>
			                        </span>
			                    @endif

			            </div>

						<div class="form-group{{ $errors->has('day') ? ' has-error' : '' }}">

			                <label for="day" class="col-md-2 control-label">Date streamed/recorded</label>

			                    <input type = "date" id="day" class="form-control" name="day" value="{{ old('day') }}" autofocus />

			                    @if ($errors->has('day'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('day') }}</strong>
			                        </span>
			                    @endif

			            </div>

			            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

			                <label for="password" class="col-md-2 control-label">Authenticate</label>

			                    <input type = "password" id="password" class="form-control" name="password" autofocus />

			                    @if ($errors->has('password'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('password') }}</strong>
			                        </span>
			                    @endif

			            </div>

			            <div class="form-group">
			                <div class="col-md-8 col-md-offset-2">
			                    <button type="submit">
			                        Submit
			                    </button>
			                </div>
			            </div>


					</form>

					<audio controls src = "http://gdev.ddns.net:8899/stream.mp3"></audio>
					<br>

					<div class = "eight columns">
						<!-- participant input -->

						<!-- ongoing description input -->

						<!-- tag input. this is unnecessary until there are a lot of podcasts. maybe a croak can point to a podcast -->

						<!-- file upload form -->

						<!-- set current image (select from frogpond images) -->

					</div>

					<div class = "four columns">
						<!-- listener count -->
						<!-- live chat -->
					</div>



			</div>
		</div>

</html>
