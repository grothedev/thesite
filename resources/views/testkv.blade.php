<!DOCTYPE html>
<html >
	<center>
	{{ Form::open( array('action' => 'KVController@store') ) }}
        k {{ Form::text('k') }}<br>
        v {{ Form::text('v') }}<br>
        pass {{ Form::password('auth')}}<br>
		{{ Form::submit('add key and value') }}
	{{ Form::close() }}
	</center>
</html>
