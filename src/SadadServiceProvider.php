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
    }

    public function register()
    {
        $this->app->bind('sadad', function($app) {
            return new Sadad();
        });
//        $this->app->singleton(Sadad::class,function (){
//            return new Sadad();
//        });
    }
}
