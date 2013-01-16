<h1>Menus</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Slug</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($navigation->groups() as $group)
			<tr>
				<td>{{ $group->title }}</td>
				<td>{{ $group->slug }}</td>
				<td>
					<a href="{{ $url->to('admin/navigation/menu/'.$group->slug) }}" class="btn btn-warning">Edit</a>
					<a href="{{ $url->to('admin/navigation/menu/'.$group->slug.'/delete') }}" class="btn btn-danger">Disable</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

<a href="{{ $url->to('admin/navigation/menu/add') }}" class="btn">Add Menu</a>