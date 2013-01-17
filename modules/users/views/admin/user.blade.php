@if($editing)
	<h3>Edit User</h3>
@else
	<h3>Create User</h3>
@endif

<div class="span6">
	{{ Form::open() }}

		{{ Form::text('email', Input::old('email', $user->email), array('class' => 'span6', 'placeholder' => 'Email'))}}

		{{ Form::password('password', array('class' => 'span6', 'placeholder' => 'Password')) }}

		{{ Form::password('password_confirmation', array('class' => 'span6', 'placeholder' => 'Confirm Password')) }}

		<hr>

		{{ Form::text('first_name', Input::old('first_name', $user->first_name), array('class' => 'span6', 'placeholder' => 'First Name')) }}

		{{ Form::text('last_name', Input::old('last_name', $user->last_name), array('class' => 'span6', 'placeholder' => 'Last Name'))}}

		{{ Form::select('group', $groups, Input::old('group', $user->group_id), array('class' => 'span6'))}}

		{{ Form::submit('Save', array('class' => 'btn')) }}
	{{ Form::close() }}
</div>