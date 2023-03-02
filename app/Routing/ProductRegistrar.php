<?php

namespace App\Routing;

use App\Http\Controllers\ProductController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class ProductRegistrar {
    public function map( Registrar $registrar ): void {
        Route::middleware( 'web' )
             ->group( function () {
                 Route::get( 'product/{product:slug}', ProductController::class )
                      ->name( 'product' );
             } );
    }
}
