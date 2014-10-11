@extends('layout.frontpage')

@section('title')
	{{ Config::get('laravel-blog/meta.index_page.page_title') }}
@endsection

@section('meta_description')
	{{ Config::get('laravel-blog/meta.index_page.meta_description') }}
@endsection

@section('meta_keywords')
	{{ Config::get('laravel-blog/meta.index_page.meta_keywords') }}
@endsection
@section('header')
<style>
.blog-header {
  padding-top: 20px;
  padding-bottom: 20px;
}
.blog-title {
  margin-top: 30px;
  margin-bottom: 0;
  font-size: 60px;
  font-weight: normal;
}
.blog-description {
  font-size: 20px;
  color: #999;
}


/*
 * Main column and sidebar layout
 */

.blog-main {
  font-size: 18px;
  line-height: 1.5;
}

/* Sidebar modules for boxing content */
.sidebar-module {
  padding: 15px;
  margin: 0 -15px 15px;
}
.sidebar-module-inset {
  padding: 15px;
  background-color: #f5f5f5;
  border-radius: 4px;
}
.sidebar-module-inset p:last-child,
.sidebar-module-inset ul:last-child,
.sidebar-module-inset ol:last-child {
  margin-bottom: 0;
}


/*
 * Blog posts
 */

.item {
  margin-bottom: 60px;
}
.item--title {
  margin-bottom: 5px;
  font-size: 40px;
}
.item--date{
	 margin-bottom: 20px;
  	color: #999;
}
.item--thumb{
	margin-right:10px;
}
</style>
@stop
@section('content')
<div class="container">
	<div class="blog-header">
        <h1 class="blog-title">X-Press Cards</h1>
        <p class="lead blog-description">The official news and reviews of X-Press Cards</p>
	</div>
	<div class="row">
		<div class="col-sm-8 blog-main">
			@include('partials.list')
		</div><!--end column-->
		<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
          	@include('partials.archives')
          </div>
 		</div><!--end column-->
	</div><!--end row-->
</div><!--end container-->
@stop