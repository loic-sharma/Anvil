<h1>Themes</h1>

<form method="POST" action="{{ $url->to('admin/templates') }}" accept-charset="utf-8">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Default Theme</th>
				<th>Theme</th>
				<th>Description</th>
				<th>Author</th>
				<th>Version</th>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($templates->get() as $template)
				<tr>
					<td>
						@if($template->slug == Input::old('template', Settings::get('template')))
							<input type="radio" name="template" value="{{ $template->slug }}" checked="checked">
						@else
							<input type="radio" name="template" value="{{ $template->slug }}">
						@endif
					</td>
					<td>{{ $template->name }}</td>
					<td>{{ $template->description }}</td>
					<td>{{ $template->author }}</td>
					<td>{{ $template->version }}</td>
					<td>
						<a href="{{ $url->to('admin/template/'. $template->slug .'/enable') }}" class="btn btn-success">Enable</a>
						<a href="{{ $url->to('admin/template/'. $template->slug .'/preview') }}" class="btn btn-success">Preview</a>
						<a href="{{ $url->to('admin/template/'. $template->slug .'/delete') }}" class="btn btn-danger">Delete</a> 
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<input type="submit" value="Save" class="btn">
</form>