<?php

/** @var \Illuminate\Routing\Router  $router */

//$router->model('categories', 'Ibec\Content\Category');

$router->get('product-categories/get-filters', 'ProductCategoriesController@getFilters');
$router->get('product-categories/get-parent-filters', 'ProductCategoriesController@getParentFilters');
$router->resource('product-categories', 'ProductCategoriesController');

$router->resource('filters', 'FiltersController');
$router->resource('product-brands', 'ProductBrandsController');

$router->get('products/get-info', 'ProductsController@getInfo');
$router->resource('products', 'ProductsController');
