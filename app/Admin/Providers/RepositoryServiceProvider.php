<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Admin\Repositories\Admin\AdminRepositoryInterface' => 'App\Admin\Repositories\Admin\AdminRepository',
        'App\Admin\Repositories\User\UserRepositoryInterface' => 'App\Admin\Repositories\User\UserRepository',
        'App\Admin\Repositories\Setting\SettingRepositoryInterface' => 'App\Admin\Repositories\Setting\SettingRepository',
        'App\Admin\Repositories\ProductCategory\ProductCategoryRepositoryInterface' => 'App\Admin\Repositories\ProductCategory\ProductCategoryRepository',
        'App\Admin\Repositories\Product\ProductRepositoryInterface' => 'App\Admin\Repositories\Product\ProductRepository',
        'App\Admin\Repositories\Category\CategoryRepositoryInterface' => 'App\Admin\Repositories\Category\CategoryRepository',
        'App\Admin\Repositories\Post\PostRepositoryInterface' => 'App\Admin\Repositories\Post\PostRepository',
        'App\Admin\Repositories\Order\OrderRepositoryInterface' => 'App\Admin\Repositories\Order\OrderRepository',
        'App\Admin\Repositories\Order\OrderDetailRepositoryInterface' => 'App\Admin\Repositories\Order\OrderDetailRepository',

    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach ($this->repositories as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
