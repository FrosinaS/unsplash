<?php

namespace Frosinas\Unsplash;

use Frosinas\Unsplash\Services\TokenService;
use Frosinas\Unsplash\Services\TokenServiceInterface;
use Frosinas\Unsplash\Services\UnsplashAuthenticationService;
use Frosinas\Unsplash\Services\UnsplashAuthenticationServiceInterface;
use Frosinas\Unsplash\Services\UnsplashAuthorizationService;
use Frosinas\Unsplash\Services\UnsplashAuthorizationServiceInterface;
use Illuminate\Support\ServiceProvider;

class UnsplashProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->app->make(UnsplashController::class);

        $this->app->bind(UnsplashAuthenticationServiceInterface::class, UnsplashAuthenticationService::class);
        $this->app->bind(UnsplashAuthorizationServiceInterface::class, UnsplashAuthorizationService::class);
        $this->app->bind(TokenServiceInterface::class, TokenService::class);

        $this->mergeConfigFrom(
            __DIR__.'/config/unsplash.php', 'unsplash'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([
            __DIR__.'/config/unsplash.php' => config_path('unsplash.php'),
        ]);
    }
}
