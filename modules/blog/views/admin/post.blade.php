@if($editing)
	<h3>Edit Post</h3>
@else
	<h3>Create a Post</h3>
@endif

<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">

	<input type="text" name="title" value="{{ Input::old('title', $post->title) }}" class="span12">

	<textarea name="content" rows="10" cols="50" class="span12">{{ Input::old('content', $post->content) }}</textarea>

	<label class="checkbox">
		@if(Input::old('comments_enabled', $post->comments_enabled))
			<input checked="checked" type="checkbox" name="comments_enabled" value="1">
		@else
			<input type="checkbox" name="comments_enabled" value="1">
		@endif

		Enable Comments.
	</label>

	<input type="submit" value="Save" class="btn">
</form>