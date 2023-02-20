<?php

namespace Tests\Unit\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
use Tests\TestCase;

final class TelegramBotApiTest extends TestCase {
    public function test_send_message_success_fake_instance(): void {
        TelegramBotApi::fake()->returnTrue();
        $result = app( TelegramBotApiContract::class )::sendMessage( '', 1, 'Testing' );

        $this->assertTrue( $result );
    }

    public function test_send_message_fail_fake_instance(): void {
        TelegramBotApi::fake()->returnFalse();
        $result = app( TelegramBotApiContract::class )::sendMessage( '', 1, 'Testing' );

        $this->assertFalse( $result );
    }
}
