<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AuthRegistrar implements RouteRegistrar {
    public function map( Registrar $registrar ): void {

        Route::middleware( 'web' )->group( function () {

            Route::controller( SignInController::class )
                 ->group( function () {
                     Route::get( '/login', 'page' )->name( 'login.page' );
                     Route::post( '/login', 'handle' )->name( 'login.handle' )->middleware( 'throttle:auth' );
                     Route::delete( '/logout', 'logout' )->name( 'logout' );
                 } );

            Route::controller( SignUpController::class )
                 ->prefix( 'sign-up' )
                 ->group( function () {
                     Route::get( '/', 'page' )->name( 'register.page' );
                     Route::post( '/', 'handle' )->name( 'register.handle' )->middleware( 'throttle:auth' );
                 } );

            Route::controller( ResetPasswordController::class )
                 ->prefix( 'reset-password' )
                 ->group( function () {
                     Route::get( '/{token}', 'page' )->name( 'password.reset' );
                     Route::post( '/', 'handle' )->name( 'resetPassword' )->middleware( 'guest' );
                 } );

            Route::controller( ForgotPasswordController::class )
                 ->prefix( 'forgot-password' )
                 ->middleware( 'guest' )
                 ->group( function () {
                     Route::get( '/', 'page' )->name( 'forgot.page' );
                     Route::post( '/', 'handle' )->name( 'forgot.handle' );
                 } );

            Route::controller( ResetPasswordController::class )
                 ->prefix( 'reset-password' )
                 ->middleware( 'guest' )
                 ->group( function () {
                     Route::get( '/', 'page' )->name( 'password.request' );
                     Route::post( '/', 'handle' )->name( 'password.update' );
                 } );
            Route::controller( SocialAuthController::class )
                 ->group( function () {
                     Route::get( '/auth/socialite/{driver}', 'redirect' )->name( 'socialite.redirect' );
                     Route::get( '/auth/socialite/{driver}/callback', 'callback' )->name( 'socialite.callback' );
                 } );
        } );


    }
}
