@if($page->hasBreadcrumbs())
	<ul class="breadcrumb">
		@foreach($page->breadcrumbs() as $breadcrumb)
			@if($breadcrumb->hasLink())
				<li>
					<span class="dividider">/</span>
					<a href="{{ $breadcrumb->link() }} ">{{{ $breadcrumb }}}</a>
				</li>
			@else
				<li class="active">{{{ $breadcrumb }}}</span>
			@endif
		@endforeach
    </ul>
@endif