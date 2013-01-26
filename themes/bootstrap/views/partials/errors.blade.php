@foreach($errors->all(':message') as $error)
	<div class="alert">
		<span><b>Error:</b> {{ $error }}</span>
	</div>
@endforeach
