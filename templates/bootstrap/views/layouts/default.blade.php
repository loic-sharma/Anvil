<!doctype html>
<html>

	<head>
		<title>{{ $page->title() }}</title>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

		{{ $template->assets('css') }}
	</head>

	<body>
		{{ $template->partial('navigation') }}

		<div class="container">

			{{ $template->partial('breadcrumbs') }}
			{{ $template->partial('errors') }}

			<div class="row">
				<div class="span8">
					{{ $page->content() }}
				</div>

				{{ $template->partial('sidebar') }}
			</div>
		</div>

		{{ $template->assets('js') }}
	</body>
</html>