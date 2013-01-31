@if($group->exists)
	<h3>Edit Group</h3>
@else
	<h3>Create Group</h3>
@endif

<div class="span6">
	<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">

		<input type="text" name="name" value="{{ Input::old('name', $group->name) }}" class="span6" placeholder="Name">

		<input type="text" name="power" value="{{ Input::old('power', $group->power) }}" class="span6" placeholder="Power">

		<input type="submit" value="Save" class="btn">
	</form>
</div>