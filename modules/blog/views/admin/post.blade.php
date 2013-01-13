<h3>Edit Post</h3>

{{ Form::open() }}

	{{ Form::text('title', Input::old('title', $post->title), array('class' => 'span12'))}}

	{{ Form::textarea('content', Input::old('content', $post->content), array('class' => 'span12')) }}

	{{ Form::submit('Save', array('class' => 'btn')) }}
{{ Form::close() }}