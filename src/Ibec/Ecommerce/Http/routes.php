<?php

/** @var \Illuminate\Routing\Router  $router */

//$router->model('categories', 'Ibec\Content\Category');

$router->get('product-categories/get-filters', 'ProductCategoriesController@getFilters');
$router->get('product-categories/get-parent-filters', 'ProductCategoriesController@getParentFilters');
$router->resource('product-categories', 'ProductCategoriesController');
//$router->delete('product-categories/batch/delete', 'ProductCategoriesController@destroyBatch');

$router->resource('filters', 'FiltersController');
$router->resource('product-brands', 'ProductBrandsController');
$router->resource('product-sectors', 'ProductSectorsController');

$router->get('products/get-info', 'ProductsController@getInfo');
$router->resource('products', 'ProductsController');
$router->resource('special-offers', 'SpecialOffersController');
$router->resource('banners', 'BannersController');

$router->get('orders/get-info', 'OrdersController@getInfo');
$router->resource('orders', 'OrdersController');
