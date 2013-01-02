<h1>{{ $post->title }}</h1>

<p class="muted">Posted by {{ $post->author->display_name }} three days ago.</p>
<p>This is the post!</p>
<p><a href="comments.php">3 Comments</a></p>

<hr>

@if($post->comments_enabled)
  {{ View::make('blog::comments', array('comments' => $post->comments)) }}
@endif
