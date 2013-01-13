<h3>Edit Page</h3>

{{ Form::open() }}

	{{ Form::text('title', Input::old('title', $page->title), array('class' => 'span12'))}}

	{{ Form::textarea('content', Input::old('content', $page->content), array('class' => 'span12')) }}

	{{ Form::submit('Save', array('class' => 'btn')) }}
{{ Form::close() }}