<?php

namespace App\Providers;

use App\Models\Dustbin;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerTheme(mix('css/filament.css'));
        });

        Filament::pushMeta([
            new HtmlString('<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/css/ol.css" type="text/css">'),
                new HtmlString('
                <style>
                    .map {
                        height: 400px;
                        width: 100%;
                    }
                </style>
                '),
        ]);

        Filament::registerScripts([
            'https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js',
            asset('map.js'),
        ]);

        Model::unguard();

//        if(Dustbin::count()>0) {
//            Dustbin::where('filling_percent','>=', 90)
//                ->where('is_full', false)->get()
//                ->each(function ($dustbin){
//                    $dustbin->update(['is_full' => true]);
//            });
//
//            Dustbin::where('filling_percent','<=', 90)
//                ->where('is_full', true)->get()
//                ->each(function ($dustbin){
//                    $dustbin->update(['is_full' => false]);
//            });
//        }

    }
}
