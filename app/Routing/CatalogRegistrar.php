<?php

namespace App\Routing;

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class CatalogRegistrar {
    public function map( Registrar $registrar ) {
        Route::middleware( 'web' )
             ->group( function () {
                 Route::get( '/catalog/{category:slug?}', CatalogController::class )
                      ->name( 'catalog' );
             } );


    }
}
