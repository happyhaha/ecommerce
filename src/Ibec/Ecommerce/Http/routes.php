<?php

/** @var \Illuminate\Routing\Router  $router */

//$router->model('categories', 'Ibec\Content\Category');

$router->get('product-categories/get-filters', 'ProductCategoriesController@getFilters');
$router->get('product-categories/get-parent-filters', 'ProductCategoriesController@getParentFilters');
$router->get('product-categories/get-tags', 'ProductCategoriesController@getTags');
$router->resource('product-categories', 'ProductCategoriesController');


$router->bind('tree', function($value)
{
	//Make sure root resolving works only with root elements
	return Ibec\Ecommerce\Database\ProductCategory::find($value);
});

$router->put('categories/{tree}/all', [
		'as' => admin_prefix('categories.tree.all'),
		'uses' => 'ProductCategoriesController@putTree',
	]);


//$router->delete('product-categories/batch/delete', 'ProductCategoriesController@destroyBatch');

$router->resource('product-brands', 'ProductBrandsController');
$router->resource('product-sectors', 'ProductSectorsController');

$router->get('products/get-info', 'ProductsController@getInfo');
$router->resource('products', 'ProductsController');
$router->resource('special-offers', 'SpecialOffersController');
$router->resource('banners', 'BannersController');


$router->get('orders/get-info', 'OrdersController@getInfo');
$router->get('orders/autocomplete', ['as' => 'admin.ecommerce.orders.autocomplete', 'uses'=>'OrdersController@autocomplete']);
$router->get('orders/user-autocomplete', ['as' => 'admin.ecommerce.orders.userAutocomplete', 'uses'=>'OrdersController@userAutocomplete']);
$router->resource('orders', 'OrdersController');

$router->get('sliders/get-info', 'SlidersController@getInfo');
$router->get('sliders/get-rows', 'SlidersController@getModelItems');
$router->resource('sliders', 'SlidersController');

$router->get('images', 'ImagesController@index');
