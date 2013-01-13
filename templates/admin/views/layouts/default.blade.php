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
				<li>
					<a href="#">Admin</a>
					<span class="divider">/</span>
				</li>
				<li class="active">Home</li>
			</ul>
			
			<div class="alert">
				<span>
					<b>Warning!</b> Alerts may warn users of impending danger.
				</span>
			</div>
		</div>
	</body>
</html>