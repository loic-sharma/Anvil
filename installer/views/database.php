<?php foreach($errors->all() as $error): ?>
	<?php echo $error; ?>
<?php endforeach; ?>

<form method="POST" action="<?php echo Request::url(); ?>">
 	
 	<div>
		<input type="text" name="hostname" value="<?php echo Input::old('hostname', 'localhost'); ?>">
	</div>

	<div>
		<input type="text" name="username" value="<?php echo Input::old('username', 'root'); ?>">
	</div>

	<div>
		<input type="password" name="password" value="<?php echo Input::old('password', 'root'); ?>">
	</div>

	<div>
		<input type="text" name="database" value="<?php echo Input::old('database', 'database'); ?>">
	</div>

	<div>
		<input type="submit" value="Next Step">
	</div>
</form>