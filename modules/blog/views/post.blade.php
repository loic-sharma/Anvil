<h1>{{ $post->title }}</h1>

<p class="muted">Posted by {{ $post->author->displayName() }} {{ $post->date() }}.</p>
<p>{{ $post->content }}</p>
<p><span class="badge">{{ $post->comments->count() }} Comments</span></p>

@if($post->comments_enabled)
	<hr>

	{{ View::make('comments::comments', array('area' => 'blog-post-'.$post->id)) }}
@endif
