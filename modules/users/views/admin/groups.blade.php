<h1>Groups</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Power</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users->groups() as $group)
			<tr>
				<td>{{ $group->name }}</td>
				<td>{{ $group->power }}</td>
				<td>
					<a href="{{ $url->to('admin/users/group/'.$group->id.'/edit') }}" class="btn btn-warning">Edit</a>
					<a href="{{ $url->to('admin/users/group/'.$group->id.'/delete') }}" class="btn btn-danger">Disable</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>