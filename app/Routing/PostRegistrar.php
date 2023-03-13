<?php

declare( strict_types=1 );

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\PostController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class PostRegistrar implements RouteRegistrar {
    public function map( Registrar $registrar ): void {
        Route::controller( PostController::class )->middleware( 'web' )->prefix( 'blog' )->group( function () {
            Route::get( '/', 'index' )->name( 'posts' );
            Route::get( '/{post:slug}', 'show' )->name( 'posts.show' );
        } );
    }
}
