<!doctype html>
<html>

	<head>
		<title>{{ $page->title() }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

		{{ $theme->assets('css') }}
	</head>

	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="{{{ $url->base() }}}">{{{ $page->title }}}</a>
			
					<div class="navbar-content">
						<ul class="nav">
							{{ $navigation->menu('admin') }}
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<ul class="breadcrumb">
				@foreach($page->breadcrumbs() as $breadcrumb)
					@if($breadcrumb->hasLink())
						<li>
							<a href="{{ $breadcrumb->link() }} ">{{ $breadcrumb }}</a>
							<span class="divider">/</span>
						</li>
					@else
						<li class="active">{{ $breadcrumb }}</span>
		   			@endif
				@endforeach
			</ul>

			@if(isset($message))
				<div class="alert alert-success">
					<span>{{ $message }}</span>
				</div>
			@endif

			@foreach($errors->all(':message') as $error)
				<div class="alert">
					<span><b>Error:</b> {{{ $error }}}</span>
				</div>
			@endforeach

			{{ $page->content() }}
		</div>

		{{ $theme->assets('js') }}
	</body>
</html>