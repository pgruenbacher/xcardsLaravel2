@if ($breadcrumbs)
<div class="breadcrumbs">
	    <ul>
	        @foreach ($breadcrumbs as $breadcrumb)
	            @if (!$breadcrumb->last)
	                <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
	            @else
	                <li class="active">{{{ $breadcrumb->title }}}</li>
	            @endif
	        @endforeach
	    </ul>
</div>


@endif