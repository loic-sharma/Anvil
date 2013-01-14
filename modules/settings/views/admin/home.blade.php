<h1>Settings</h1>

{{ Form::open() }}
	<table class="table table-striped table-bordered">
		<tbody>
			<tr>
				<td>Title</td>
				<td>{{ Form::text('title', Input::old('title', Settings::get('title'))) }}</td>
			</tr>
			<tr>
				<td>Template</td>
				<td>{{ Form::select('templates', array()) }}</td>
			</tr>
		</tbody>
	</table>

	{{ Form::submit('Save', array('class' => 'btn'))}}
{{ Form::close() }}