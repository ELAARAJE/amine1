<?php

namespace App\Providers;

use App\Models\OpeningHour;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));

        View::composer('layouts.public', function ($view) {
            $openingHours = OpeningHour::orderBy('day_of_week')
                ->orderBy('id')
                ->get()
                ->groupBy('day_of_week');

            $dayNames = [
                0 => 'Dimanche',
                1 => 'Lundi',
                2 => 'Mardi',
                3 => 'Mercredi',
                4 => 'Jeudi',
                5 => 'Vendredi',
                6 => 'Samedi',
            ];

            $view->with('footerOpeningHours', $openingHours)
                 ->with('footerDayNames', $dayNames);
        });
    }
}
