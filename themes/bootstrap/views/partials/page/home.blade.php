<h1>{{{ $page->title }}}</h1>

<p contenteditable="true">{{ $page->content }}</p>

@if($page->commentsEnabled)
	{{ $comments->show('page-'.$page->slug) }}
@endif