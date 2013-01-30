@if($editing)
	<h3>Edit Link</h3>
@else
	<h3>Add Link</h3>
@endif

<div class="span6">
	<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">
		<input type="text" name="title" value="{{ Input::old('title', $link->title) }}" class="span6" placeholder="Title">

		<input type="text" name="url" value="{{ Input::old('url', $link->url) }}" class="span6" placeholder="Url">

		<input type="text" name="required_power" value="{{ Input::old('required_power', $link->required_power) }}" class="span6" placeholder="Required Power">

		<input type="submit" value="Save" class="btn">
	</form>
</div>