<?php

namespace Laravel\Dusk;

use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        Route::get('/_dusk/login/{userId}/{guard?}', [
            'middleware' => 'web',
            'uses' => 'Laravel\Dusk\Http\Controllers\UserController@login',
        ]);

        Route::get('/_dusk/logout/{guard?}', [
            'middleware' => 'web',
            'uses' => 'Laravel\Dusk\Http\Controllers\UserController@logout',
        ]);

        Route::get('/_dusk/user/{guard?}', [
            'middleware' => 'web',
            'uses' => 'Laravel\Dusk\Http\Controllers\UserController@user',
        ]);

        $this->publishes([
            __DIR__.'/../config/dusk.php' => config_path('dusk.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @throws Exception
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dusk.php', 'dusk');

        if ($this->app->environment('production')) {
            throw new Exception('It is unsafe to run Dusk in production.');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
                Console\DuskCommand::class,
                Console\DuskServeCommand::class,
                Console\MakeCommand::class,
                Console\PageCommand::class,
            ]);
        }
    }
}
