<!DOCTYPE html>
<html >
	<center>
	{{ Form::open( array('action' => 'SiteController@appendThought') ) }}
		{{ Form::hidden('tag', $t) }}
		{{ Form::textarea('text') }}
		{{ Form::submit('append thought') }}
	{{ Form::close() }}
	</center>
</html>
