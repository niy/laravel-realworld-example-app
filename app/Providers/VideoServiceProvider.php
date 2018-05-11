<?php

namespace App\Providers;

use App\RealWorld\Video\Storage\ArvanCloudStorage;
use App\RealWorld\Video\VideoHelper;
use Illuminate\Support\ServiceProvider;

class VideoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\RealWorld\Video\VideoHelperInterface', function($app) {
            $arvanCloudStorage = new ArvanCloudStorage();
            return new VideoHelper($arvanCloudStorage);
        });
    }
}
