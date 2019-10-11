<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

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
        Schema::defaultStringLength(191); //NEW: Increase StringLength
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(1));

        Passport::refreshTokensExpireIn(now()->addDays(15));

        Passport::personalAccessTokensExpireIn(now()->addMonths(1));
    }
}
