<?php

return [

    'filters' => [
        'index' => 'Фильтры',
        'create' => 'Добавление фильтра',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование фильтра',

        'fields' => [
            'id' => 'ID',
            'title' => 'Заголовок',
            'images' => 'Изображения',
        ],
    ],

    'product-categories' => [
        'index' => 'Категории товаров',
        'create' => 'Добавление категории',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование категории',

        'fields' => [
            'id' => 'ID',
            'title' => 'Заголовок',
            'parent_id' => 'Родительская категория',
            'slug' => 'Машинное имя',
            'content' => 'Описание',
            'filters' => 'Фильтры',
            'seo_description' => 'SEO Описание',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
        ],

        'hints' => [
            'filter_title' => 'Название фильтра',
        ],
    ],

    'product-brands' => [
        'index' => 'Бренды товаров',
        'create' => 'Добавление бренда',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование бренда',

        'fields' => [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Описание',
            'status' => 'Статус',
            'seo_description' => 'SEO Описание',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
        ],

        'hints' => [
        ],
    ],

    'product-sectors' => [
        'index' => 'Отрасли товаров',
        'create' => 'Добавление отрасли',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование отрасли',

        'fields' => [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Описание',
            'status' => 'Статус',
            'seo_description' => 'SEO Описание',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
        ],

        'hints' => [
        ],
    ],

    'special-offers' => [
        'index' => 'Акции',
        'create' => 'Добавление акции',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование акции',

        'fields' => [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Описание',
            'seo_description' => 'SEO Описание',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
        ],

        'hints' => [
        ],
    ],

    'banners' => [
        'index' => 'Баннеры',
        'create' => 'Добавление баннера',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование баннера',

        'fields' => [
            'name' => 'Название баннера',
            'link' => 'Ссылка',
            'is_blank' => 'Открывать в новой вкладке',
            'width' => 'Ширина',
            'height' => 'Высота',
            'code' => 'Код баннера',
            'max_views' => 'Максимальное кол-во просмотров',
            'current_views' => 'Текущее кол-во просмотров',
            'untill_at' => 'Показывать до',
            'status' => 'Статус',
        ],

        'hints' => [
        ],
    ],

    'products' => [
        'index' => 'Товары',
        'create' => 'Добавление товара',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование товара',

        'fields' => [
            'id' => 'ID',

            'product_brand_id' => 'Бренд (Производитель)',
            'slug' => 'Машинное-имя',
            'article_number' => 'Артикул',
            'price' => 'Цена',
            'price_new' => 'Цена акционная',
            'quantity' => 'Кол-во',
            'type' => 'Тип',
            'rating' => 'Рейтинг',
            'is_hot' => 'Продвигаемый товар',
            'status' => 'Статус видимости',

            'title' => 'Заголовок',
            'content' => 'Описание',
            'delivery' => 'Доставка',
            'preparing' => 'Предпродажная подготовка',
            'review' => 'Обзор',
            'warranty_short' => 'Гарантия (краткое описание)',
            'warranty' => 'Гарантия (полное описание)',
            'additional' => 'Запасные части',

            'seo_description' => 'SEO Описание',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
        ],

        'hints' => [
            'title' => 'Наименование товара',
            'delivery' => 'Условия доставки. Текст будет отображен на странице карточки товара, в пункте "Доставка"',
        ],
    ],

    'orders' => [
        'index' => 'Заказы',
        'create' => 'Добавление заказа',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование заказа',

        'fields' => [
            'user_id' => 'Пользователь',
            'payment_type' => 'Тип оплаты',
            'delivery_type' => 'Тип доставки',
            'delivery_price' => 'Стоимость доставки',
            'city' => 'Город',
            'address' => 'Адрес',
            'comment' => 'Комментарий',
            // 'total_price' => 'Итоговая стоимость',
            'payment_status' => 'Статус оплаты',
            'status' => 'Статус',
        ],

        'hints' => [
        ],
    ],

    'sliders' => [
        'index' => 'Слайдеры',
        'create' => 'Добавление слайдера',
        'empty' => 'Нет записей',
        'edit' => 'Редактирование слайдера',

        'fields' => [
            'model_type' => 'Модуль',
            'model_id' => 'Запись',
            'status' => 'Статус',
        ],

        'hints' => [
        ],
    ],

    'actions' => [
        'apply' => 'Применить',
        'delete_selected' => 'Удалить выбранные',
        'create' => 'Создать',
        'image_delete' => 'Удалить',
        'image_add' => 'Добавить файл',
        'image_change' => 'Изменить'
    ],

];
