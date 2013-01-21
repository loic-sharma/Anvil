@if($editing)
	<h3>Edit Permission</h3>
@else
	<h3>Create Permission</h3>
@endif

<div class="span6">
	{{ Form::open() }}

		{{ Form::text('name', Input::old('name', $permission->name), array('class' => 'span6', 'placeholder' => 'Name')) }}

		{{ Form::text('slug', Input::old('slug', $permission->slug), array('class' => 'span6', 'placeholder' => 'Slug')) }}

		{{ Form::text('required_power', Input::old('required_power', $permission->required_power), array('class' => 'span6', 'placeholder' => 'Required Power')) }}

		{{ Form::text('max_power', Input::old('max_power', $permission->max_power), array('class' => 'span6', 'placeholder' => 'Max Power')) }}

		{{ Form::submit('Save', array('class' => 'btn')) }}
	{{ Form::close() }}
</div>