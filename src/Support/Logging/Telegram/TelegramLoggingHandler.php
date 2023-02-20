<?php

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\TelegramBotApiContract;

class TelegramLoggingHandler extends AbstractProcessingHandler {


    protected string $chatId;
    protected string $token;

    public function __construct( array $config ) {

        $level = Logger::toMonologLevel( $config['level'] );
        parent::__construct( $level );

        $this->chatId = $config['chat_id'];
        $this->token  = $config['token'];
    }


    protected function write( array $record ): void {
        app( TelegramBotApiContract::class )::sendMessage(
            $this->token,
            $this->chatId,
            $record['formatted']
        );
    }
}
