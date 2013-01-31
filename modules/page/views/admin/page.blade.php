@if($page->exists)
	<h3>Edit Page</h3>
@else
	<h3>Create Page</h3>
@endif

<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">

	<input type="text" name="title" value="{{ Input::old('title', $page->title) }}" class="span12">

	<textarea name="content" rows="10" class="span12">{{ Input::old('content', $page->content) }}</textarea>

	<label class="checkbox">
		@if(Input::old('comments_enabled', $page->comments_enabled))
			<input type="checkbox" name="comments_enabled" value="1" checked="checked">
		@else
			<input type="checkbox" name="comments_enabled" value="1">	
		@endif
		Enable Comments.
	</label>

	<input type="submit" value="Save" class="btn">
</form>