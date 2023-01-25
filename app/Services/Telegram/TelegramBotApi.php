<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Psy\Exception\ErrorException;

final class TelegramBotApi {

    public const HOST = 'https://api.telegram1.org/bot';

    public static function sendMessage( string $token, int $chatId, string $text ) {
        try {
            $response = Http::get( self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text'    => $text,
            ] );
        } catch ( \Exception ) {
            return abort( 404, 'Api not found' );
        }

        return $response->ok();
    }
}
