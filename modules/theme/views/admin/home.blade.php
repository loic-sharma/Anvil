<h1>Themes</h1>

<form method="POST" action="{{ $url->to('admin/themes') }}" accept-charset="utf-8">
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
			{{-- @foreach($themes->get() as $theme) --}}
			@foreach(array() as $theme)
				<tr>
					<td>
						@if($theme->slug == Input::old('theme', Settings::get('theme')))
							<input type="radio" name="theme" value="{{ $theme->slug }}" checked="checked">
						@else
							<input type="radio" name="theme" value="{{ $theme->slug }}">
						@endif
					</td>
					<td>{{ $theme->name }}</td>
					<td>{{ $theme->description }}</td>
					<td>{{ $theme->author }}</td>
					<td>{{ $theme->version }}</td>
					<td>
						<a href="{{ $url->to('admin/theme/'. $theme->slug .'/preview') }}" class="btn btn-success">Preview</a>
						<a href="{{ $url->to('admin/theme/'. $theme->slug .'/delete') }}" class="btn btn-danger">Delete</a> 
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<input type="submit" value="Save" class="btn">
</form>