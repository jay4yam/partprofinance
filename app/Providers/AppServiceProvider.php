<?php

namespace App\Providers;

use App\Http\ViewComposers\EndettementComposer;
use App\Http\ViewComposers\StatistiquesComposer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //commentaire
        Schema::defaultStringLength(191);

        // utilise la classe endettementComposer pour renvoyer le tableau 'revenus/charges' à la vue
        View::composer('endettement._prospectgraph', EndettementComposer::class);

        // utilise la classe statistiqueComposer pour renvoyer des variables à vue 'home' (stats)
        View::composer('home', StatistiquesComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
