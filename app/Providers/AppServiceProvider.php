<?php

namespace App\Providers;

use App\Http\ViewComposers\CommerciauxComposer;
use App\Http\ViewComposers\EndettementComposer;
use App\Http\ViewComposers\LeadStatComposer;
use App\Http\ViewComposers\MonthsAndYearsForFilterComposer;
use App\Http\ViewComposers\StatistiquesComposer;
use App\Http\ViewComposers\StatistiquesSaleComposer;
use App\Http\ViewComposers\TaskComposer;
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

        // utilise la classe LeadStatComposer pour renvoyer des variables à vue 'stats._leadsStats' (stats)
        View::composer('stats._leadsStats', LeadStatComposer::class);

        // utilise la classe LeadStatComposer pour renvoyer des variables à vue 'stats._leadsStats' (stats)
        View::composer('task._taskHome', TaskComposer::class);

        //renvois les mois et années de creation des prospects et des dossiers en base
        View::composer(['filters._prospect', 'filters._dossier', 'home'], MonthsAndYearsForFilterComposer::class);

        View::composer(['filters._prospect', 'filters._dossier'], CommerciauxComposer::class);

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
