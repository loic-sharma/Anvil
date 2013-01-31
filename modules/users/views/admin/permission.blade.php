@if($permission->exists)
	<h3>Edit Permission</h3>
@else
	<h3>Create Permission</h3>
@endif

<div class="span6">
	<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">

		<input type="text" name="name" value="{{ Input::old('name', $permission->name) }}" class="span6" placeholder="Name">

		<input type="text" name="slug" value="{{ Input::old('slug', $permission->slug) }}" class="span6" placeholder="Slug">

		<input type="text" name="required_power" value="{{ Input::old('required_power', $permission->required_power) }}" class="span6" placeholder="Required Power">

		<input type="text" name="max_power" value="{{ Input::old('max_power', $permission->max_power) }}" class="span6" placeholder="Max Power">

		<input type="submit" value="Save" class="btn">
	</form>
</div>