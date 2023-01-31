<?php

namespace App\Services\Telegram;

use App\Exceptions\TelegramApiException;
use Exception;
use Illuminate\Support\Facades\Http;
use Throwable;

final class TelegramBotApi {

    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage( string $token, int $chatId, string $text ) {

        try {
            $response = Http::get( self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text'    => $text,
            ] );
        } catch ( Exception $e ) {
            return abort( 404, $e->getMessage() );
        }

        return $response->ok();
    }
}
