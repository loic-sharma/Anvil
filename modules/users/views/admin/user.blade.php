@if($editing)
	<h3>Edit User</h3>
@else
	<h3>Create User</h3>
@endif

<div class="span6">
	<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">

		<input type="text" name="email" value="{{ Input::old('email', $user->email) }}" class="span6" placeholder="Email">

		<input type="password" name="password" class="span6" placeholder="Password">

		<input type="password" name="password_confirmation" class="span6" placeholder="Confirm Password">

		<hr>

		<input type="text" name="first_name" value="{{ Input::old('first_name', $user->first_name) }}" class="span6" placeholder="First Name">

		<input type="text" name="last_name" value="{{ Input::old('last_name', $user->last_name) }}" class="span6" placeholder="Last Name">

		<select name="group" class="span6">
			@foreach($groups->get() as $group)
				@if(Input::old('group', $user->group_id) == $group->id)
					<option value="{{ $group->id }}" selected>{{ $group->name }}</option>
				@else
					<option value="{{ $group->id }}">{{ $group->name }}</option>
				@endif
			@endforeach
		</select>

		<input type="submit" value="Save" class="btn">
	</form>
</div>