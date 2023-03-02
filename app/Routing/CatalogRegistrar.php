<?php

namespace App\Routing;

use App\Http\Controllers\CatalogController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class CatalogRegistrar {
    public function map( Registrar $registrar ) {
        Route::middleware( 'web' )
             ->group( function () {
                 Route::get( '/catalog/{category:slug?}', CatalogController::class )
                      ->middleware( 'list_grid' )
                      ->name( 'catalog' );
             } );


    }
}
