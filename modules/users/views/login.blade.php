<h2 class="page-title" id="page_title">Login</h2>


{{ Form::open('users/login', 'POST', array('id' => 'login')) }}

<ul>
	<li>
		{{ Form::label('email', 'E-mail') }}
		{{ Form::text('email', Input::old('email')) }}
	</li>
	<li>
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password') }}
	</li>
	<li id="remember_me">
		{{ Form::label('remember', 'Remember Me') }}
		{{ Form::checkbox('remember', Input::old('remember')) }}
	</li>
	<li class="form_buttons">
		{{ form::submit('Login') }} <span class="register"> | <a href="{{ URL::to('users/register') }}">Register</a></span>
	</li>
	<li class="reset_pass">
		<a href="{{ URL::to('users/forgot') }}">Forgot your password?</a>
	</li>
</ul>
{{ Form::close() }}