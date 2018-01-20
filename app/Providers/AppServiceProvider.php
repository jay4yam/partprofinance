<?php

namespace App\Providers;

use App\Http\ViewComposers\EndettementComposer;
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
