<h3>Comments</h3>

@if($comments->count() > 0)
	@foreach($comments as $comment)
		<div class="row">
			<div class="span2">
				  <img src="{{ $comment->author->gravatarUrl(100) }}" class="img-polaroid" width="100" height="100"> 
	   		</div>
	   		<div class="span6">
	   			<p class="muted">Posted by {{ $comment->author->display_name }} one day ago.</p>
	   			<p>{{ $comment->content }}</p>
	   		</div>
	   	</div>
    @endforeach
@else
	<p>No comments.</p>
@endif

<hr>

<h3>Post Comment</h3>

{{ Form::open() }}
	{{ Form::textarea('comment', null, array('rows' => '5', 'placeholder' => 'Comment', 'class' => 'span8')) }}

	{{ Form::submit('Post', array('class' => 'btn')) }}
{{ Form::close() }}