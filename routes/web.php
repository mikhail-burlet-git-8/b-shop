<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get( '/', HomeController::class )->name( 'home' );

Route::controller( AuthController::class )->group( function () {
    Route::get( '/login', 'login' )->name( 'login' );
    Route::post( '/login', 'signIn' )->name( 'signIn' )->middleware( 'throttle:auth' );;
    Route::get( '/sign-up', 'signUp' )->name( 'signUp' );
    Route::post( '/sign-up', 'store' )->name( 'store' )->middleware( 'throttle:auth' );;
    Route::get( '/reset-password', 'resetPassword' )->name( 'resetPassword' );
    Route::delete( '/logout', 'logOut' )->name( 'logOut' );

    Route::get( '/forgot-password', 'forgot' )
         ->middleware( 'guest' )
         ->name( 'password.request' );

    Route::post( '/forgot-password', 'forgotPassword' )
         ->middleware( 'guest' )
         ->name( 'forgotPassword' );

    Route::get( '/reset-password/{token}', 'reset' )
         ->middleware( 'guest' )
         ->name( 'password.reset' );

    Route::post( '/reset-password/', 'passwordReset' )
         ->middleware( 'guest' )
         ->name( 'password.update' );


    Route::get( '/auth/socialite/github', 'github' )->name( 'socialite.github' );

    Route::get( '/auth/socialite/github/callback', 'githubCallback' )
         ->name( 'socialite.github.callback' );


} );
