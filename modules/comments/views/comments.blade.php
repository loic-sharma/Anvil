<h3>Comments</h3>

@if($comments->count() > 0)
	@foreach($comments as $comment)
		<div class="row">
			<div class="span2">
				  <img src="{{{ $comment->author->gravatarUrl(100) }}}" class="img-polaroid" width="100" height="100"> 
	   		</div>
	   		<div class="span6">
	   			<p class="muted">Posted by {{{ $comment->author }}} {{{ $comment->timeAgo }}}.</p>
	   			<p>{{ $comment->content }}</p>
	   		</div>
	   	</div>
    @endforeach
@else
	<p>No comments.</p>
@endif

@if($user->can('post_comment'))
	<hr>

	<h3>Post Comment</h3>

	<form method="POST" action="{{ $url->to('comments/post') }}" accept-charset="utf-8">
		<input type="hidden" name="area" value="{{{ $area }}}">

		<textarea name="content" rows="5" placeholder="Comment" class="span8"></textarea>

		<input type="submit" value="Post" class="btn">
	</form>
@endif