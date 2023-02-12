<?php

namespace App\Providers;

use Domain\Auth\Providers\ActionServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider {

    public function register(): void {
        $this->app->register( ActionServiceProvider::class );
    }

}
