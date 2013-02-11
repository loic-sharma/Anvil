<!doctype html>
<html>

	<head>
		<title>{{ $page->title() }}</title>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

		{{{ $theme->assets('css') }}}
	</head>

	<body>
		{{{ $theme->partial('navigation') }}}

		<div class="container">

			{{{ $theme->partial('breadcrumbs') }}}
			{{{ $theme->partial('errors') }}}

			<div class="row">
				<div class="span8">
					{{{ $page->content() }}}
				</div>

				{{{ $theme->partial('sidebar') }}}
			</div>
		</div>

		{{{ $theme->assets('js') }}}
	</body>
</html>