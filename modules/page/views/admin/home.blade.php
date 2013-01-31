<h1>Pages</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Title</th>
			<th>Layout</th>
			<th>Slug</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($pages->get() as $page)
			<tr>
				<td>{{ $page->title }}</td>
				<td>{{ $page->layout }}</td>
				<td>{{ $page->slug }}</td>
				<td>
					<a href="{{ $url->to('page/'.$page->slug) }}" class="btn btn-success">View</a>
					<a href="{{ $url->to('admin/page/'.$page->slug.'/edit') }}" class="btn btn-warning">Edit</a>
					<a href="{{ $url->to('admin/page/'.$page->slug.'/delete') }}" class="btn btn-danger">Delete</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

<a href="{{ $url->to('admin/page/create') }}" class="btn">Create Page</a>