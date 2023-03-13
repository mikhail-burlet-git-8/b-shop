<?php

declare( strict_types=1 );

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class CartRegistrar implements RouteRegistrar {
    public function map( Registrar $registrar ): void {
        Route::controller( CartController::class )
             ->middleware( 'web' )
             ->prefix( 'cart' )
             ->group( function () {
                 Route::get( '/', 'index' )->name( 'cart' );
                 Route::post( '/{product}/add', 'add' )->name( 'cart.add' );
                 Route::post( '/{item}/quantity', 'quantity' )->name( 'cart.quantity' );
                 Route::delete( '/{item}/delete', 'delete' )->name( 'cart.delete' );
                 Route::delete( '/clear', 'clear' )->name( 'cart.clear' );
             } );
    }
}
