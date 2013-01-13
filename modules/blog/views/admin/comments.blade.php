<h1>Comments</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Post Title</th>
			<th>Author</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($blog->comments() as $comment)
			<tr>
				<td>{{ $comment->post->title }}</td>
				<td>{{ $comment->author->displayName() }}</td>
				<td>{{ $comment->date() }}</td>
				<td>
					<a href="{{ $url->to('blog/post/'.$comment->post->id) }}" class="btn btn-success">View</a>
					<a href="{{ $url->to('admin/blog/comment/'.$comment->id) }}" class="btn btn-warning">Edit</a>
					<a href="{{ $url->to('admin/blog/comment/'.$comment->id.'/delete') }}" class="btn btn-danger">Delete</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>