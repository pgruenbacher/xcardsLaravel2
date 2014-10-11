<div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container-fluid container">
          <div class="navbar-header">
          	<img class="navbar-logo navbar-brand" src="{{URL::asset('assets/images/BunnyMenu.gif')}}"/>
          	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <i style="color:white" class="fa fa-list fa-lg"></i>
	            <span class="sr-only">Toggle navigation</span>
	        </button>
            <a class="navbar-brand" href="{{URL::route('home')}}">X-Press Cards</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
    		 @if(Auth::check())
              	<li class="{{Request::is('build*') ? 'active' : ''}}"><a href="{{URL::route('build-index')}}">Make My Card</a></li>
        		<li class="{{Request::is('previous') ? 'active':''}}"><a href="{{URL::route('build-previous')}}">Review Cards</a></li>
        		<li class="{{Request::is('address*') ? 'active' : ''}}"><a href="{{URL::route('address-book.index')}}">My Address Book</a></li>
  	   		</ul>
            <ul class="nav navbar-nav navbar-right">
            @if(Auth::user()->hasRole('admin'))
            <li><a href="{{URL::to('admin')}}">Admin</a></li>
            @endif
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                <ul class="dropdown-menu">
                 	<li><a href="{{URL::route('account-sign-out')}}">Sign Out</a></li>
					<li><a href="{{URL::route('account-change-password')}}">Change Password</a></li>
                	<li class="divider"></li>
                  	<li class="dropdown-header">Addresses</li>
                  	<li><a href="{{URL::route('address-book.index')}}">My Address Book</a></li>
                  	<li class="dropdown-header">My Account</li>
                  	<li><a>My Credits: <span class="credits" style="color:red">{{Auth::user()->credits}}</span></a></li>
                  	<li><a href="{{URL::route('buy-credits')}}">Buy Credits</a></li>
                  	<li><a href="{{URL::route('buy-credits')}}">Previous Orders</a></li>
                </ul>
              </li>
          	@else
              	<li class="{{Request::is('build*') ? 'active' : ''}}"><a href="{{URL::route('build-index')}}">Make My Card</a></li>
    			<li><a href="{{URL::route('account-sign-in')}}">Sign In</a></li>
        		<li><a href="{{URL::route('account-create')}}">Create Account</a></li>
        	@endif
            </ul>
          </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</div><!--end navbar-->

