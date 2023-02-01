<?php

namespace App\Services\Telegram\Exception;

use Exception;

class TelegramApiException extends Exception {
    public function render() {
        return response()->json( [] );
    }
}
