<!doctype html>
<html lang="en" ng-app="app">
  <head>
    <meta charset="utf-8" />
    <title>Laravel 4 E-Commerce</title>
    	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/jtable.css')}}" />
	
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/main.min.css')}}">
	
	<!--Font Awesome -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	
	<!-- Angular-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0rc1/angular.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.0-beta.3/angular-cookies.min.js"></script>

</head>
  <body ng-controller="main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>
            X-Cards 4 E-Commerce
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8" ng-controller="products">
		  <h2>
		    Products
		  </h2>
		  <!--Category Buttons-->
	  <div class="categories btn-group">
		    <button type="button"
		    class="category btn btn-default active"
		    ng-click="products.setCategory(null)"
		    ng-class="{ 'active' : products.category == null }">
			    All
			  </button>
		  <button type="button"
		    class="category btn btn-default"
		    ng-repeat="category in products.categories"
		    ng-click="products.setCategory(category)"
		    ng-class="{ 'active' : products.category.id == category.id }">
		    @{{ category.name }}
		  </button>
		</div>
		<div class="products">
			<div class="products">
  				<div  class="product media" ng-repeat="product in products.products | filter : products.filterByCategory">
			    <button
				type="button"
		  		class="pull-left btn btn-default"
		 		ng-click="products.addToBasket(product)"
				>
	  			Add to basket
	  			</button>
		      <div class="media-body">
		        <h4 class="media-heading">@{{ product.name }}</h4>
		        <p>
		          Price: @{{ product.price }}, Stock: @{{ product.stock }}
		        </p>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
     <div class="col-md-4" ng-controller="basket">
	  <h2>
	    Basket
	  </h2>
	  <form class="basket">
	    <table class="table">
	      <tr
	        class="product"
	        ng-repeat="product in basket.products track by $index"
	        ng-class="{ 'hide' : basket.state != 'shopping' }"
	      >
	        <td class="name">
	          @{{ product.name }}
	        </td>
	        <td class="quantity">
	          <input
	            class="form-control"
	            type="number"
	            ng-model="product.quantity"
	            ng-change="basket.update()"
	            min="1"
	          />
	        </td>
	        <td class="product">
	          @{{ product.total }}
	        </td>
	        <td class="product">
	          <btn type="button"
	            class="remove glyphicon glyphicon-remove"
	            ng-click="basket.remove(product)"
	          ></btn>
	        </td>
	      </tr>
	      <tr>
	        <td
	          colspan="4"
	          ng-class="{ 'hide' : basket.state != 'shopping' }"
	        >
	          <input
	            type="text"
	            class="form-control"
	            placeholder="email"
	            ng-model="basket.email"
	          />
	        </td>
	      </tr>
	      <tr>
	        <td
	          colspan="4"
	          ng-class="{ 'hide' : basket.state != 'shopping' }"
	        >
	          <input
	            type="password"
	            class="form-control"
	            placeholder="password"
	            ng-model="basket.password"
	          />
	        </td>
	      </tr>
	      <tr>
	        <td
	          colspan="4"
	          ng-class="{ 'hide' : basket.state != 'shopping' }"
	        >
	          <button
	            type="button"
	            class="pull-left btn btn-default"
	            ng-click="basket.authenticate()"
	          >
	            Authenticate
	          </button>
	        </td>
	      </tr>
	      <tr>
	        <td
	          colspan="4"
	          ng-class="{ 'hide' : basket.state != 'paying' }"
	        >
	          <input
	            type="text"
	            class="form-control"
	            placeholder="card number"
	            ng-model="basket.number"
	          />
	        </td>
	      </tr>
	      <tr>
	        <td
	          colspan="4"
	          ng-class="{ 'hide' : basket.state != 'paying' }"
	        >
	          <input
	            type="text"
	            class="form-control"
	            placeholder="expiry"
	            ng-model="basket.expiry"
	          />
	        </td>
	      </tr>
	      <tr>
	        <td
	          colspan="4"
	          ng-class="{ 'hide' : basket.state != 'paying' }"
	        >
	          <input
	            type="text"
	            class="form-control"
	            placeholder="security number"
	            ng-model="basket.security"
	          />
	        </td>
	      </tr>
	      <tr>
	        <td
	          colspan="4"
	          ng-class="{ 'hide' : basket.state != 'paying' }"
	        >
	          <button
	            type="button"
	            class="pull-left btn btn-default"
	            ng-click="basket.pay()"
	          >
	            Pay
	          </button>
	        </td>
	      </tr>
	    </table>
	  </form>
	</div>
	</div> <!-- End Row -->
</div> <!-- End Container -->
  	<script type="text/javascript" src="{{ asset("js/shared.js") }}"></script>
  </body>
</html>