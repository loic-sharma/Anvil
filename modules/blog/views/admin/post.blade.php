@if($editing)
	<h3>Edit Post</h3>
@else
	<h3>Create a Post</h3>
@endif

{{ Form::open() }}

	{{ Form::text('title', Input::old('title', $post->title), array('class' => 'span12'))}}

	{{ Form::textarea('content', Input::old('content', $post->content), array('class' => 'span12')) }}

	<label class="checkbox">
		{{ Form::checkbox('comments_enabled', 1, Input::old('comments_enabled', $post->comments_enabled)) }} Enable Comments.
	</label>

	{{ Form::submit('Save', array('class' => 'btn')) }}
{{ Form::close() }}