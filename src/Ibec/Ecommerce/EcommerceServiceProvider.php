<?php

namespace Ibec\Ecommerce;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class EcommerceServiceProvider extends ServiceProvider
{

    /**
     * Controllers base namespace
     *
     * @var string
     */
    protected $namespace = 'Ibec\Ecommerce\Http\Controllers';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $codename = 'ecommerce';
        $baseDir = __DIR__.'/../../../';

        $this->loadViewsFrom($baseDir . 'resources/views', $codename);
        $this->loadTranslationsFrom($baseDir . 'resources/lang', $codename);

        //Publish migrations
        $this->publishes([
             $baseDir . 'database/migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        // Публикует папку public (со статикой вроде js, css и т.д.)
        $this->publishes([
            $baseDir . 'public' => public_path('vendor/'.$codename),
        ], 'public');

        $this->bootRoutes();

        if (!$this->app->runningInConsole()) {
            app('admin_menu')->addSection($codename, trans('Каталог'));
            app('admin_menu')->addItem($codename, admin_route($codename.'.products.index'), 'Товары');
            app('admin_menu')->addItem($codename, admin_route($codename.'.product-categories.index'), 'Категории');
            app('admin_menu')->addItem($codename, admin_route($codename.'.product-brands.index'), 'Бренды');
            app('admin_menu')->addItem($codename, admin_route($codename.'.product-sectors.index'), 'Отрасли');
            app('admin_menu')->addItem($codename, admin_route($codename.'.special-offers.index'), 'Акции');
            app('admin_menu')->addItem($codename, admin_route($codename.'.banners.index'), 'Баннеры');
            app('admin_menu')->addItem($codename, admin_route($codename.'.sliders.index'), 'Слайдеры');
            app('admin_menu')->addItem($codename, admin_route($codename.'.orders.index'), 'Заказы');

            // app('admin_menu')->addItem('ecommerce', admin_route($codename.'.items'), 'Товары');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Load service routes
     *
     * @return void
     */
    protected function bootRoutes()
    {
        $group = [
            'namespace' => $this->namespace,
            'prefix' => $this->app['config']->get('admin.uri', 'admin') . '/ecommerce',
            'middleware' => $this->app['config']->get('admin.middlewares'),
        ];

        $this->app['router']->group($group, function (Router $router) {
            require __DIR__ . '/Http/routes.php';
        });
    }
}
