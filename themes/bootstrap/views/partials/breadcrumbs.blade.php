@if($page->hasBreadcrumbs())
	<ul class="breadcrumb">
		@foreach($page->breadcrumbs() as $breadcrumb)
			@if($breadcrumb->hasLink())
				<li>
					<a href="{{ $breadcrumb->link() }} ">{{ $breadcrumb }}</a>
					<span class="dividider">/</span>
				</li>
			@else
				<li class="active">{{ $breadcrumb }}</span>
			@endif
		@endforeach
    </ul>
@endif