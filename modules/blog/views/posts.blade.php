@if($posts->count() > 0)
	@foreach($posts as $post)
		<div class="post">
			<!-- Post heading -->
			<h3><a href="{{{ $post->url() }}}">{{{ $post->title }}}</a></h3>
			
			<div class="meta muted">
				<div class="date">
					Posted
					<span>{{{ $post->timeAgo }}}.</span>
				</div>

				<div class="author">
					by
					<span>{{{ $post->author }}}</span>
				</div>
			</div>
			<div class="content">
				{{ $post->content }}
			</div>
		</div>
	@endforeach
@else
	<p>This blog has no posts!</p>
@endif