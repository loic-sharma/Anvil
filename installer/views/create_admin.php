<?php foreach($errors->all() as $error): ?>
	<?php echo $error; ?>
<?php endforeach; ?>

<form method="POST" action="<?php echo Request::url(); ?>">
 	
 	<div>
		<input type="text" name="email" value="<?php echo Input::old('email', 'admin@example.com'); ?>">
	</div>

	<div>
		<input type="password" name="password">
	</div>

	<div>
		<input type="password" name="password_confirmation">
	</div>

	<div>
		<input type="submit" value="Next Step">
	</div>
</form>