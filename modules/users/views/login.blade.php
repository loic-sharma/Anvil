<h1>Login</h1>

<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">
	<div class="control-group">
		<div class="controls">
			<input type="text" name="email" value="{{ Input::old('email') }}" placeholder="Username" class="input-large">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<input type="password" name="password" placeholder="Password" class="input-large">
		</div>
	</div>

	<input type="submit" value="Login" class="btn">
</form>