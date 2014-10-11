<div class="previewBanner">
	<div class="container">
		<div class="row yellowBanner">
			<div class="col-sm-7 col-xs-12">
				<div class="inline-divs">
					<div class="previewContainer">
						{{$card->renderThumbnail()}}
					</div>
					<div class="previewContainer">
						{{$card->renderBackSideSmall()}}
					</div>	
				</div>
			</div>
			<div class="col-sm-5 col-xs-12">
				<h1>@yield('banner-title')</h1>
				<p>@yield('banner-instructions')</p>
			</div>
		</div>
	</div>
</div>
