<?php

namespace App\Providers;
use Carbon\Carbon;

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
        // Set Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');

        // Jika server mendukung, ini bantu Carbon menggunakan bulan lokal
        setlocale(LC_TIME, 'id_ID.UTF-8');
    }
}