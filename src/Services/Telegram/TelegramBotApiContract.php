<?php

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\Exception\TelegramApiException;
use Throwable;

interface TelegramBotApiContract {
    public static function sendMessage( string $token, int $chatId, string $text ): bool;
}
