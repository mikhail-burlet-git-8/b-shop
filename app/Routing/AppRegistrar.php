<?php

namespace App\Routing;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AppRegistrar {
    public function map( Registrar $registrar ) {
        Route::middleware( 'web' )
             ->group( function () {
                 Route::get( '/', HomeController::class )
                      ->name( 'home' );
                 Route::get( 'storage/images/{dir}/{id}/{method}/{size}/{file}', ThumbnailController::class )
                      ->where( 'method', 'resize|crop|fit' )
                      ->where( 'size', '\d+x\d+' )
                      ->where( 'file', '.+\.(png|jpg|webp|jpeg)' )
                      ->name( 'thumbnail' );
             } );


    }
}
