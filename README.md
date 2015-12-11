# Пакет IbecSystems Ecommerce

## Introduction

Пакет был сделан с целью упросить и ускорить создание витрин и каталогов на проектах.

## Рабочие модули:

* Модуль каталога товаров
* Модуль категорий товаров
* Модуль брендов товаров
* Модуль фильтров (редактируются из категорий и из товаров)

## Структура и организация файлов

### Особенности:

* Контроллеры упрощены до максимума. Все имеют родительский контроллер BaseController,
в котором содержатся все основные методы. Если надо что-то сделать иначе,
перепешите метод в дочернем контроллере
* Для работы с моделями, были сделаны репозитории (хоть и криво). В итоге контроллеры не знают напрямую,
с какими моделями они работают.
* Все репозитории упрощены до максимума. Все имеют родительский репозиторий BaseRepository.

### Дерево файлов:

```
├── database
│   ├── migrations
│   │   ├── 2015_11_30_075800_create_product_category_tables.php
│   │   ├── 2015_11_30_075932_create_filter_group_table.php
│   │   ├── 2015_11_30_083613_create_filter_group_nodes_table.php
│   │   ├── 2015_11_30_085557_create_filters_table.php
│   │   ├── 2015_11_30_094406_create_filter_nodes_table.php
│   │   ├── 2015_12_08_050931_create_product_brands_tables.php
│   │   └── 2015_12_08_085236_create_products_tables.php
│   └── seeds
├── public
│   └── js
│       └── angular
│           ├── product_category.controller.js
│           └── product_category.service.js
├── resources
│   ├── lang
│   │   ├── en
│   │   │   └── default.php
│   │   └── ru
│   │       └── default.php
│   └── views
│       ├── filters
│       │   ├── form.blade.php
│       │   └── index.blade.php
│       ├── _form
│       │   └── group.blade.php
│       ├── _menu
│       │   └── posts.php
│       ├── product-brands
│       │   ├── form.blade.php
│       │   └── index.blade.php
│       ├── product-categories
│       │   ├── form.blade.php
│       │   └── index.blade.php
│       ├── back.blade.php
│       └── dashboard.blade.php
├── src
│   └── Ibec
│       └── Ecommerce
│           ├── Database
│           │   ├── FilterGroupNode.php
│           │   ├── FilterGroup.php
│           │   ├── FilterNode.php
│           │   ├── Filter.php
│           │   ├── MiscTrait.php
│           │   ├── ProductBrandNode.php
│           │   ├── ProductBrand.php
│           │   ├── ProductCategoryNode.php
│           │   └── ProductCategory.php
│           ├── Http
│           │   ├── Controllers
│           │   │   ├── BaseController.php
│           │   │   ├── FiltersController.php
│           │   │   ├── ProductBrandsController.php
│           │   │   ├── ProductCategoriesController.php
│           │   │   └── ProductsController.php
│           │   ├── Requests
│           │   │   └── PostFormRequest.php
│           │   └── routes.php
│           ├── BaseRepository.php
│           ├── EcommerceServiceProvider.php
│           ├── FilterRepository.php
│           ├── ProductBrandRepository.php
│           ├── ProductCategoryRepository.php
│           └── ProductsRepository.php

```
