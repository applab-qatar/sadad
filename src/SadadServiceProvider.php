<?php
namespace Applab\Sadad;
use Illuminate\Support\ServiceProvider;
class SadadServiceProvider extends ServiceProvider
{

    const CONFIG_PATH = __DIR__ . '/../config/sadad-config.php';
    // const ROUTE_PATH = __DIR__ . '/../routes';
    const MIGRATION_PATH = __DIR__ . '/../migrations';

    public function boot()
    {
        $this->loadViews();
        $this->publish();
        // $this->loadRoutesFrom(self::ROUTE_PATH . '/web.php');
    }

    private function publish()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('applab-sadad.php')
        ], 'config');

        $this->publishes([
            self::MIGRATION_PATH => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/sadad'),
        ],'views');
    }
    /**
     * Load and publish package views.
     *
     * @return void
     */
    private function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sadad');

    }

    public function register()
    {
        $this->app->bind('sadad', function($app) {
            return new Sadad();
        });
    }
}
