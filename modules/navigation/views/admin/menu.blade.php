@if($editing)
	<h3>Edit Menu</h3>
@else
	<h3>Add Menu</h3>
@endif

<div class="span6">
	{{ Form::open() }}

		{{ Form::text('title', Input::old('title', $menu->title), array('class' => 'span6', 'placeholder' => 'Title'))}}

		{{ Form::text('slug', Input::old('slug', $menu->slug), array('class' => 'span6', 'placeholder' => 'Slug')) }}

		{{ Form::submit('Save', array('class' => 'btn')) }}
	{{ Form::close() }}
</div>