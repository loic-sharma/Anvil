<h1>Posts</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Title</th>
			<th>Author</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($blog->posts() as $post)
			<tr>
				<td>{{ $post->title }}</td>
				<td>{{ $post->author->displayName() }}</td>
				<td>{{ $post->date() }}</td>
				<td>
					<a href="{{ $url->to('blog/post/'.$post->id) }}" class="btn btn-success">View</a>
					<a href="{{ $url->to('admin/blog/post/'.$post->id) }}" class="btn btn-warning">Edit</a>
					<a href="{{ $url->to('admin/blog/post/'.$post->id.'/delete') }}" class="btn btn-danger">Delete</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>