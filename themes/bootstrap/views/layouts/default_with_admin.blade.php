<!doctype html>
<html>

	<head>
		<title>{{ $page->title() }}</title>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

		{{{ $theme->assets('css') }}}
	</head>

	<body>
		<div style="height: 70px; margin-top: 0px;"></div>
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

		<div id="anvil_admin_bar">
			<div id="anvil_admin_container">
				<ul>
					<li id="anvil_content">
						<a href="#" title="Content">Content</a>
					</li>
					<li id="anvil_design">
						<a href="#" title="Design">Design</a>
					</li>
					<li id="anvil_users">
						<a href="#" title="Users">Users</a>
					</li>
					<li id="anvil_settings">
						<a href="#" title="Settings">Settings</a>
					</li>
					<li id="anvil_modules">
						<a href="#" title="Modules">Modules</a>
					</li>
				</ul>
			</div>
		</div>

		<style>
		#anvil_admin_bar {
			height: 70px;
			position:fixed;
			top: 0;
			left: 0;
			font-family: 'Helvetica Nue', Helvetica, Arial, sans-serif;
			background-color: rgb(0, 0, 0);
			width: 100%;
			z-index: 99999;
		}

		#anvil_admin_container {
			width: 600px;
			margin: auto;
			margin-top: 20px;
		}

		#anvil_admin_container ul {
			list-style: none;
		}

		#anvil_admin_container ul li {
			display: inline;
			margin: 0;
			padding: 0;
		}

		#anvil_admin_container ul li a {
			display: block;
			float: left;
			width: 107px;
			color: rgb(170, 170, 170);
		}
		</style>
	</body>
</html>