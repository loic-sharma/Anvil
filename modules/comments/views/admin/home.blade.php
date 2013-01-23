<h1>Comments</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Area</th>
			<th>Author</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($comments->get() as $comment)
			<tr>
				<td>{{ $comment->areaName }}</td>
				<td>{{ $comment->author->displayName() }}</td>
				<td>{{ $comment->date() }}</td>
				<td>
					<a href="{{ $comment->areaLink }}" class="btn btn-success">View</a>
					<a href="{{ $url->to('admin/comment/'.$comment->id.'/delete') }}" class="btn btn-danger">Delete</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>