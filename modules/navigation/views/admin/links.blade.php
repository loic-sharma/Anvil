<h1>Links</h1>

@if(count($links))
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
			@foreach($links as $link)
				<tr>
					<td>{{ $link->title }}</td>
					<td><a href="{{ $link->url }}">{{ $link->url }}</a></td>
					<td>{{ $link->requiredPower() }}</td>
					<td>
						<a href="{{ $url->to('admin/navigation/link/'.$link->id.'/edit') }}" class="btn btn-warning">Edit</a>
						<a href="{{ $url->to('admin/navigation/menu/'.$link->group->slug.'/link/'.$link->id.'/delete') }}" class="btn btn-danger">Delete</a> 
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<p>This menu has no links. Add some!</p>
@endif

<a href="{{ $url->to('admin/navigation/menu/'.$menu.'/add-link') }}" class="btn">Add Link</a>