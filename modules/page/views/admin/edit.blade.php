<h3>Edit Page</h3>

{{ Form::open() }}

	{{ Form::text('title', Input::old('title', $page->title), array('class' => 'span12'))}}

	{{ Form::textarea('content', Input::old('content', $page->content), array('class' => 'span12')) }}

	<label class="checkbox">
		{{ Form::checkbox('comments_enabled', 1, Input::old('comments_enabled', $page->comments_enabled)) }} Enable Comments.
	</label>

	{{ Form::submit('Save', array('class' => 'btn')) }}
{{ Form::close() }}