<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Push the TokenMismatch handler into the web middleware group so that
        // TokenMismatchException (CSRF failure) is handled gracefully and
        // users are redirected back to the login with a friendly message.
        try {
            $router = $this->app->make(\Illuminate\Routing\Router::class);
            $router->pushMiddlewareToGroup('web', \App\Http\Middleware\HandleTokenMismatch::class);
        } catch (\Exception $e) {
            // If router is not available during certain CLI tasks, ignore.
        }
    }
}
