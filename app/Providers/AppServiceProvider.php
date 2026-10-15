<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register anonymous component paths
        Blade::anonymousComponentPath(resource_path('views/user/components'), 'user');

        // Explicitly register user components for direct <x-user.components.*> and <x-*> tag usage
        $components = [
            'navbar' => 'user.components.navbar',
            'footer' => 'user.components.footer',
            'product-card' => 'user.components.product-card',
            'product-badge' => 'user.components.product-badge',
            'newsletter' => 'user.components.newsletter',
            'logo' => 'user.components.logo',
        ];

        foreach ($components as $alias => $view) {
            Blade::component($view, $alias);
            Blade::component($view, 'user.components.' . $alias);
        }
    }
}
