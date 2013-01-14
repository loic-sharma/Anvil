<h1>Users</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Email</th>
			<th>Name</th>
			<th>Registration Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users->get() as $user)
			<tr>
				<td>{{ $user->email }}</td>
				<td>{{ $user->displayName() }}</td>
				<td>{{ $user->date() }}</td>
				<td>
					<a href="{{ $url->to('admin/users/'.$user->id.'/edit') }}" class="btn btn-warning">Edit</a>
					<a href="{{ $url->to('admin/users/'.$user->id.'/delete') }}" class="btn btn-danger">Delete</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>