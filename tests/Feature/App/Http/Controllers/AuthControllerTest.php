<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
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

class AuthControllerTest extends TestCase {
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

    public function test_it_login_page_success(): void {
        $this->get( action( [ SignInController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Вход в аккаунт' )
             ->assertViewIs( 'auth.login' );
    }

    public function test_it_signup_page_success(): void {
        $this->get( action( [ SignUpController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Регистрация' )
             ->assertViewIs( 'auth.sign-up' );
    }

    public function test_it_forgot_password_page_success(): void {
        $this->get( action( [ ForgotPasswordController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Забыли пароль' )
             ->assertViewIs( 'auth.forgot-password' );
    }

    public function test_it_reset_password_page_success(): void {
        $this->get( route( 'password.reset', 'token' ) )
             ->assertOk()
             ->assertSee( 'Восстановление пароля' )
             ->assertViewIs( 'auth.reset-password' );
    }

    public function test_it_logout_page_success(): void {
        $user = UserFactory::new()->create( [
            'email' => 'mihail.burlet@gmail.com'
        ] );

        $this->actingAs( $user )->delete( action( [ SignInController::class, 'logout' ] ) );

        $this->assertGuest();
    }

    public function test_it_sign_in_success(): void {

        $password = str()->random( 8 );
        $user     = UserFactory::new()->create( [
            'email'    => 'mihail.burlet@gmail.com',
            'password' => bcrypt( $password ),
        ] );

        $response = $this->post( action( [ SignInController::class, 'handle' ] ), [
            'email'    => 'mihail.burlet@gmail.com',
            'password' => $password,
        ] );

        $response->assertValid()->assertRedirect( route( 'home' ) );

    }

    public function test_it_reset_password_success() {

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

        $response->assertRedirect( route( 'login.page' ) );

    }


}
