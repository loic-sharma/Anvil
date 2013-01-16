<h1>Links</h1>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>URL</th>
			<th>Required Power</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($navigation->menu($menu) as $link)
			<tr>
				<td>{{ $link->title }}</td>
				<td><a href="{{ $link->url }}">{{ $link->url }}</a></td>
				<td>{{ $link->requiredPower() }}</td>
				<td>
					<a href="{{ $url->to('admin/navigation/group/'.$link->id.'/edit') }}" class="btn btn-warning">Edit</a>
					<a href="{{ $url->to('admin/navigation/group/'.$link->id.'/delete') }}" class="btn btn-danger">Disable</a> 
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

<a href="{{ $url->to('admin/navigation/'.$menu.'/create') }}" class="btn">Add Link</a>