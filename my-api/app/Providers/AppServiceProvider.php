<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as ValidatorFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Illuminate\Contracts\Routing\ResponseFactory::class, function() {
            return new \Laravel\Lumen\Http\ResponseFactory();
        });
    }
    public function boot(ValidatorFactory $validator, DatabaseManager $db){

        $validator->setPresenceVerifier(new DatabasePresenceVerifier($db));

    }
}
