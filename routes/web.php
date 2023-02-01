<?php

use Illuminate\Support\Facades\Route;

Route::get( '/', function () {

    throw new \App\Services\Telegram\Exception\TelegramApiException( 'Error' );

    // logger()->channel( 'telegram' )->debug( 'Exc' );

    return view( 'frontpage' );
} );
