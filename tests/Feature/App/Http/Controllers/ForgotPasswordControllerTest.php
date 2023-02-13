<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignInFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase {
    use RefreshDatabase;

    public function test_it_forgot_password_page_success(): void {
        $this->get( action( [ ForgotPasswordController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Забыли пароль' )
             ->assertViewIs( 'auth.forgot-password' );
    }

    public function test_it_forgot_password_not_email(): void {
        $response = $this->post( action( [ ForgotPasswordController::class, 'handle' ] ) );

        $response->assertInvalid();
    }

    public function test_it_forgot_password_sending_link(): void {

        $response = $this->post( action( [ ForgotPasswordController::class, 'handle' ] ), [
            'email' => 'mihail.burlet@gmail.com'
        ] );
        $response->assertSee( "Мы отправили ссылку для сброса пароля по электронной почте!" );
    }
}
