@if($editing)
	<h3>Edit Link</h3>
@else
	<h3>Add Link</h3>
@endif

<div class="span6">
	{{ Form::open() }}

		{{ Form::text('title', Input::old('title', $link->title), array('class' => 'span6', 'placeholder' => 'Title'))}}

		{{ Form::text('url', Input::old('url', $link->url), array('class' => 'span6', 'placeholder' => 'Url')) }}

		{{ Form::text('required_power', Input::old('required_power', $link->required_power), array('class' => 'span6', 'placeholder' => 'Required Power')) }}

		{{ Form::submit('Save', array('class' => 'btn')) }}
	{{ Form::close() }}
</div>