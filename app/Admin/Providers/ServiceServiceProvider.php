<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected $services = [
        'App\Admin\Services\Admin\AdminServiceInterface' => 'App\Admin\Services\Admin\AdminService',
        'App\Admin\Services\User\UserServiceInterface' => 'App\Admin\Services\User\UserService',
        'App\Admin\Services\ProductCategory\ProductCategoryServiceInterface' => 'App\Admin\Services\ProductCategory\ProductCategoryService',
        'App\Admin\Services\Product\ProductServiceInterface' => 'App\Admin\Services\Product\ProductService',
        'App\Admin\Services\Category\CategoryServiceInterface' => 'App\Admin\Services\Category\CategoryService',
        'App\Admin\Services\Post\PostServiceInterface' => 'App\Admin\Services\Post\PostService',
        'App\Admin\Services\Order\OrderServiceInterface' => 'App\Admin\Services\Order\OrderService',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach ($this->services as $interface => $implement) {
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
