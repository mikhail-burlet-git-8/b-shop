<?php

namespace Support\Logging\Telegram;

use Monolog\Logger;

class TelegramLoggingFactory {
    public function __invoke( array $config ) {

        $logger = new Logger( 'telegram' );
        $logger->pushHandler( new TelegramLoggingHandler( $config ) );

        return $logger;
    }
}
