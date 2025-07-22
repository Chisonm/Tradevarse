<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

final class AppServiceProvider extends ServiceProvider
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
        Vite::prefetch(concurrency: 3);
        Model::automaticallyEagerLoadRelationships();
        Model::shouldBeStrict();
        URL::forceHttps();
        Http::preventStrayRequests();
        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );
        Password::defaults(fn (): ?Password => app()->isProduction() ? Password::min(12)->max(255)->uncompromised() : null);
    }
}
