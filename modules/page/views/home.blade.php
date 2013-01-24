<h1>{{ $page->title }}</h1>

<p>{{ $page->content }}</p>

@if($page->comments_enabled)
	{{ View::make('comments::comments', array('area' => 'page-'.$page->slug))->render() }}
@endif