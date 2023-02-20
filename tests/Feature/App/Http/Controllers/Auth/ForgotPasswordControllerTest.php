<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Support\Flash\Flash;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase {
    use RefreshDatabase;

    protected function testingEmail(): array {
        return [ 'email' => 'mihail.burlet@gmail.com' ];
    }

    public function test_handle_success(): void {
        $user = UserFactory::new()->create( $this->testingEmail() );

        $this->post( action( [ ForgotPasswordController::class, 'handle' ], $this->testingEmail() ) )
             ->assertRedirect();

    }

    public function test_forgot_password_page_success(): void {
        $this->get( action( [ ForgotPasswordController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Забыли пароль' )
             ->assertViewIs( 'auth.forgot-password' );
    }

    public function test_forgot_password_not_email(): void {
        $response = $this->post( action( [ ForgotPasswordController::class, 'handle' ] ) );

        $response->assertInvalid();
    }

    public function test_forgot_password_not_user(): void {
        $this->assertDatabaseMissing( 'users', $this->testingEmail() );

        $this->post( action( [ ForgotPasswordController::class, 'handle' ], $this->testingEmail() ) )
             ->assertSessionHas( Flash::MESSAGE_KEY );

        Notification::assertNothingSent();
    }


}
