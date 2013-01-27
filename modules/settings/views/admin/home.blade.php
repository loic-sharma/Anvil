<h1>Settings</h1>

<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">
	<table class="table table-striped table-bordered">
		<tbody>
			<tr>
				<td>Title</td>
				<td><input type="text" value="{{ Input::old('title', Settings::get('title')) }}"></td>
			</tr>
			<tr>
				<td>Template</td>
				<td>
					<select name="theme">
						@foreach($themes->get() as $theme)
							@if(Settings::get('theme') == $theme->slug)
								<option value="{{ $theme->slug }}" selected>{{ $theme->name }}</option>
							@else
								<option value="{{ $theme->slug }}">{{ $theme->name }}</option>
							@endif
						@endforeach
					</select>
				</td>
			</tr>
		</tbody>
	</table>

	<input type="submit" value="Save" class="btn">
</form>