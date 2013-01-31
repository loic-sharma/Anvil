@if($menu->exists)
	<h3>Edit Menu</h3>
@else
	<h3>Add Menu</h3>
@endif

<div class="span6">
	<form method="POST" action="{{ $url->current() }}" accept-charset="utf-8">

		<input type="text" name="title" value="{{ Input::old('title', $menu->title) }}" class="span6" placeholder="Title">

		<input type="text" name="slug" value="{{ Input::old('slug', $menu->slug) }}" class="span6" placeholder="Slug">

		<input type="submit" value="Save" class="btn">
	</form>
</div>