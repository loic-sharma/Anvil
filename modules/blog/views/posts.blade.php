@if($posts->count() > 0)
	@foreach($posts as $post)
		<div class="post well">
			<!-- Post heading -->
			<h3><a href="{{$post->url()}}">{{$post->title}}</a></h3>
			
			<div class="meta muted">
				<div class="date">
					Posted on
					<span>{{$post->date()}}</span>
				</div>

				<div class="author">
					by
					<span>{{$post->author->display_name}}</span>
				</div>
			</div>
			<div class="content">
				<?php echo $post->content; ?>
			</div>
		</div>
	@endforeach
@else
@endif