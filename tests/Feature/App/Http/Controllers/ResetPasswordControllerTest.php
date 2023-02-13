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
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase {
    use RefreshDatabase;

    public function test_it_reset_password_page_success(): void {
        $this->get( route( 'password.reset', 'token' ) )
            //$this->get( action( [ ResetPasswordController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Восстановление пароля' )
             ->assertViewIs( 'auth.reset-password' );
    }


    public function test_it_reset_password_success() {
        Event::fake();
        $user = UserFactory::new()->create( [
            'email' => 'mihail.burlet@gmail.com',
        ] );

        $password = str()->random();

        $response = $this->post( action( [ ResetPasswordController::class, 'handle' ] ), [
            'email'                 => $user->email,
            'password'              => $password,
            'password_confirmation' => $password,
            'token'                 => Password::createToken( $user )
        ] );

        Event::assertDispatched( PasswordReset::class );

        $response->assertRedirect( route( 'login.page' ) );

    }


    public function test_it_reset_not_user() {

        $user = UserFactory::new()->create( [
            'email' => 'mihail.burlet@gmail.com',
        ] );

        $password = str()->random();

        $response = $this->post( action( [ ResetPasswordController::class, 'handle' ] ), [
            'email'                 => 'mihail@gmail.com',
            'password'              => $password,
            'password_confirmation' => $password,
            'token'                 => Password::createToken( $user )
        ] );

        $response->assertInvalid( [
            "email" => "Мы не можем найти пользователя с таким адресом электронной почты."
        ] );

    }

    public function test_it_reset_not_confirm_password() {

        $user = UserFactory::new()->create( [
            'email' => 'mihail.burlet@gmail.com',
        ] );

        $password = str()->random();

        $response = $this->post( action( [ ResetPasswordController::class, 'handle' ] ), [
            'email'                 => 'mihail@gmail.com',
            'password'              => $password,
            'password_confirmation' => '123',
            'token'                 => Password::createToken( $user )
        ] );

        $response->assertInvalid( [
            "password" => "Пароли не совпадают"
        ] );
    }

    public function test_it_reset_not_min_password() {

        $user = UserFactory::new()->create( [
            'email' => 'mihail.burlet@gmail.com',
        ] );

        $password = str()->random();

        $response = $this->post( action( [ ResetPasswordController::class, 'handle' ] ), [
            'email'                 => 'mihail@gmail.com',
            'password'              => '123',
            'password_confirmation' => '123',
            'token'                 => Password::createToken( $user )
        ] );

        $response->assertInvalid( [
            "password" => "Минимальное количество знаков 8"
        ] );

    }

}
