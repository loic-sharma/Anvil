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
					@if($module->hasAdminPanel)
						<a href="{{ $url->to('admin/'.$module->slug) }}" class="btn btn-success">Manage</a>
					@endif

					@if($module->isCore == false)
						<a href="{{ $url->to('admin/modules/'.$module->slug.'/disable') }}" class="btn btn-danger">Disable</a> 
					@endif

					@if($module->isCore == true and $module->hasAdminPanel == false)
						No actions.
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>