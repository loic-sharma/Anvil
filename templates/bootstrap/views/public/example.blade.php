<!doctype html>
<html>

	<head>
		<title>Example</title>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

		{{ $template->css('bootstrap.css') }}
	</head>

	<body>
		<div class="container">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="#">{{ $page->title() }}</a>

						<div class="navbar-content">
							<ul class="nav">
								{{ $navigation->links('header') }}
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h3>Example Page</h3>

					<p>This page can be accessed at <span>/example</span>.
				</div>
			</div>
		</div>
	</body>
</html>