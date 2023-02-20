<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase {
    public function test_success_user_create(): void {

        $this->assertDatabaseMissing( 'users', [ 'email' => 'test@gmail.com' ] );

        $action = app( RegisterNewUserContract::class );

        $action( NewUserDTO::make(
            'Test',
            'test@gmail.com',
            '1234567890',
        ) );

        $this->assertDatabaseHas( 'users', [ 'email' => 'test@gmail.com' ] );

    }
}
