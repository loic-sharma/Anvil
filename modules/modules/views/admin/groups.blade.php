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
		@foreach($users->group() as $group)
			<tr>
				<td>{{ $group->name }}</td>
				<td>{{ $group->power }}</td>
				<td>
					<a href="{{ $url->to('admin/'.$group->id) }}" class="btn btn-success">View</a>
					<a href="{{ $url->to('admin/modules/'.$group->id.'/disable') }}" class="btn btn-danger">Disable</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>