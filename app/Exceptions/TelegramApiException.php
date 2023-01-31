<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class TelegramApiException extends Exception {

    public function report(Throwable $exception)
    {
        return abort( 404, $exception->getMessage() );
    }
}
