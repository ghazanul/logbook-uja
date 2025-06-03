<?php

namespace App\Providers;

use App\Models\Season;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layouts.app', function ($view) {
            $seasons = Season::orderBy('name', 'desc')->get();
            $seasonSelected = request()->segment(1);
            $view->with('seasons', $seasons)->with('seasonSelected', $seasonSelected);
        });
    }
}
