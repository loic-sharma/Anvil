<!doctype html>
<html>

	<head>
		<title>{{ $page->title() }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

		{{ $template->css('bootstrap.min.css') }}
	</head>

	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="{{ $url->base() }}">{{ $page->title }}</a>
			
					<div class="navbar-content">
						<ul class="nav">
							{{ $navigation->links('admin') }}
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<ul class="breadcrumb">
				@foreach($page->breadcrumbs() as $breadcrumb)
					@if($breadcrumb->link)
						<li>
							<a href="{{ $breadcrumb->link }} ">{{ $breadcrumb->name }}</a>
							<span class="dividider">/</span>
						</li>
					@else
						<li class="active">{{ $breadcrumb->name }}</span>
		   			@endif
				@endforeach
			</ul>

			@foreach($errors->all(':message') as $error)
				<div class="alert">
					<span><b>Error:</b> {{ $error }}</span>
				</div>
			@endforeach

			{{ $page->content() }}
		</div>

		{{ $template->js('jquery.js') }}
		{{ $template->js('bootstrap-dropdown.js') }}
	</body>
</html>