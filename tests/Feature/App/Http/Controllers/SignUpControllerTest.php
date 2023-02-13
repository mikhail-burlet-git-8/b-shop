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

class SignUpControllerTest extends TestCase {
    use RefreshDatabase;

    public function test_it_store_success(): void {
        Event::fake();
        Notification::fake();

        $request = [
            'name'                  => 'Test Name',
            'email'                 => 'mihail.burlet@gmail.com',
            'password'              => 'Password5490',
            'password_confirmation' => 'Password5490',
        ];

        $this->assertDatabaseMissing( 'users', [ 'email' => $request['email'] ] );

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $request
        );
        $response->assertValid();

        $this->assertDatabaseHas( 'users', [ 'email' => $request['email'] ] );

        $user = User::query()->where( 'email', $request['email'] )->first();

        Event::assertDispatched( Registered::class );
        Event::assertListening( Registered::class, SendEmailNewUserListener::class );

        $event = new Registered( $user );

        $listener = new SendEmailNewUserListener();

        $listener->handle( $event );

        Notification::assertSentTo( $user, NewUserNotification::class );

        $this->assertAuthenticatedAs( $user );

        $response
            ->assertRedirect( route( 'home' ) );
    }

    public function test_it_store_not_valid(): void {

        $request = [
            'name'                  => 'Test Name',
            'email'                 => 'mihail.burlet@gmail123123.com',
            'password'              => 'Pass',
            'password_confirmation' => 'Password5490',
        ];

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $request
        );
        $response->assertInvalid( [
            "email"    => "Введите правильный email адрес",
            "password" => "Подтверждение пароля не совпадает.",
        ] );
    }

    public function test_it_store_user_exist(): void {

        $request = [
            'name'                  => 'Test Name',
            'email'                 => 'mihail.burlet@gmail.com',
            'password'              => 'Password5490',
            'password_confirmation' => 'Password5490',
        ];

        UserFactory::new()->create( [
            'name'  => 'Test Name',
            'email' => 'mihail.burlet@gmail.com',
        ] );

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $request
        );

        $response->assertInvalid( [
            "email" => "Такой email уже существует"
        ] );
    }

    public function test_it_store_not_min_password(): void {

        $request = [
            'name'                  => 'Test Name',
            'email'                 => 'mihail.burlet@gmail.com',
            'password'              => 'Pass',
            'password_confirmation' => 'Pass',
        ];

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $request
        );

        $response->assertInvalid( [
            "password" => "Пароль должен быть не меньше 8 символов"
        ] );
    }


    public function test_it_store_not_confirmed_password(): void {

        $request = [
            'name'                  => 'Test Name',
            'email'                 => 'mihail.burlet@gmail.com',
            'password'              => 'Password5490',
            'password_confirmation' => 'Password549',
        ];

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $request
        );

        $response->assertInvalid( [
            "password" => "Подтверждение пароля не совпадает."
        ] );
    }

    public function test_it_signup_page_success(): void {
        $this->get( action( [ SignUpController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Регистрация' )
             ->assertViewIs( 'auth.sign-up' );
    }

}
