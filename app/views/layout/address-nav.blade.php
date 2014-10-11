<nav style="margin-bottom: 0px;" class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::route('address-book.index') }}">Addressbook</a>
	</div>
	<ul class="nav navbar-nav">
		<li><a href="{{ URL::route('address-book.index') }}">View All</a></li>
		<li><a href="{{ URL::route('address-book.create') }}">Create Addresses</a>
		<li><a href="{{ URL::route('request-addresses') }}">Get Addresses</a>
	</ul>
</nav>