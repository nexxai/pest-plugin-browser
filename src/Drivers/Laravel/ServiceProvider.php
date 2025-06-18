<?php

declare(strict_types=1);

namespace Pest\Browser\Drivers\Laravel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * @internal
 */
final class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstraps the service provider.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') === true) {
            return;
        }

        Route::group(array_filter([
            'prefix' => config('pest-plugin-browser.path', '_pest-plugin-browser'),
            'domain' => config('pest-plugin-browser.domain', null),
            'middleware' => config('pest-plugin-browser.middleware', 'web'),
        ], static fn ($value): bool => $value !== null), function (): void {
            Route::get('/login/{userId}/{guard?}', [
                'uses' => 'Laravel\Dusk\Http\Controllers\UserController@login',
                'as' => 'pest-plugin-browser.login',
            ]);

            Route::get('/logout/{guard?}', [
                'uses' => 'Laravel\Dusk\Http\Controllers\UserController@logout',
                'as' => 'pest-plugin-browser.logout',
            ]);

            Route::get('/user/{guard?}', [
                'uses' => 'Laravel\Dusk\Http\Controllers\UserController@user',
                'as' => 'pest-plugin-browser.user',
            ]);
        });
    }
}
