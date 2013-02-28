<h1>{{{ $page->title }}}</h1>

<p>{{ $page->content }}</p>

@if($page->commentsEnabled)
	{{ $comments->show('page-'.$page->slug) }}
@endif