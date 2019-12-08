<?php
namespace Loot\Tenge;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Loot\Tenge\Loggers\Logger;

class ServiceProvider extends BaseServiceProvider
{
    protected $options;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/tenge.php' => config_path('tenge.php'),
        ]);
        $this->mergeConfigFrom(__DIR__.'/../config/tenge.php', 'tenge');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../assets/' => storage_path('tenge'),
        ], 'secrets');
        $this->app->singleton('tenge_logger', function () {
            return (new Logger(config('tenge.logger')))
                ->getManager();
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('tenge', Tenge::class);
    }
}
