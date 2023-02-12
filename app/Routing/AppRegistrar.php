<?php

namespace App\Routing;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AppRegistrar {
    public function map( Registrar $registrar ) {
        Route::middleware( 'web' )
             ->group( function () {
                 Route::get( '/', HomeController::class )
                      ->name( 'home' );
             } );
    }
}
