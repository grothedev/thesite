<!DOCTYPE html>
<html >
	<center>
	{{ Form::open( array('action' => 'SiteController@appendThought') ) }}
		{{ Form::textarea('t') }}
		{{ Form::submit('append thought') }}

	{{ Form::close() }}
	</center>
</html>
