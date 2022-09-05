<?php

namespace App\Providers;

use App\interfaces\IDictionnaire;
use App\interfaces\ILieu;
use App\interfaces\ILogin;
use App\interfaces\ImageInterface;
use App\services\DictionnaireService;
use App\services\ImageService;
use App\services\LieuService;
use App\services\LoginService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IDictionnaire::class, DictionnaireService::class);
        $this->app->bind(ILieu::class, LieuService::class);
        $this->app->bind(ImageInterface::class, ImageService::class);
        $this->app->bind(ILogin::class, LoginService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
