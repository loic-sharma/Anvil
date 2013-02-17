<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="{{ $url->base() }}">{{ $page->title() }}</a>

			<div class="navbar-content">
				<ul class="nav">
					{{{ $navigation->mainMenu() }}}
				</ul>
			</div>
		</div>
	</div>
</div>