@if($page->hasBreadcrumbs())
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
@endif