<h1>Login</h1>

{{ Form::open() }}
	<div class="control-group">
		<div class="controls">
			{{ Form::text('email', Input::old('email'), array('placeholder' => 'Username', 'class' => 'input-large'))}}
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			{{ Form::password('password', array('placeholder' => 'Password', 'class' => 'input-large')) }}
		</div>
	</div>

	{{ Form::submit('Login', array('class' => 'btn')) }}
{{ Form::close() }}