<h1>Modules</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Version</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($modules->get() as $module)
			<tr>
				<td>{{ $module->name }}</td>
				<td>{{ $module->description }}</td>
				<td>{{ $module->version }}</td>
				<td>
					<a href="{{ $url->to('admin/'.$module->slug) }}" class="btn btn-success">View</a>
					<a href="{{ $url->to('admin/modules/'.$module->slug.'/disable') }}" class="btn btn-danger">Disable</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>