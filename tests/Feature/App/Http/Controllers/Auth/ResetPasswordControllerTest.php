<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase {
    use RefreshDatabase;

    private string $token;
    private User $user;

    protected function setUp(): void {
        parent::setUp();

        $this->user  = UserFactory::new()->create();
        $this->token = Password::createToken( $this->user );
    }

    public function test_page_success(): void {
        $this->get( route( 'password.reset', $this->token ) )
             ->assertOk()
             ->assertViewIs( 'auth.reset-password' );
    }


    public function test_reset_password_success() {
        Event::fake();

        $password = str()->random();

        Password::shouldReceive( 'reset' )
                ->once()
                ->withSomeOfArgs( [
                    'email'                 => $this->user->email,
                    'password'              => $password,
                    'password_confirmation' => $password,
                    'token'                 => $this->token
                ] )->andReturn( Password::PASSWORD_RESET );

        $response = $this->post( action( [ ResetPasswordController::class, 'handle' ] ), [
            'email'                 => $this->user->email,
            'password'              => $password,
            'password_confirmation' => $password,
            'token'                 => $this->token
        ] );

        $response->assertRedirect( route( 'login.page' ) );

    }


    public function test_reset_not_user() {

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

    public function test_reset_not_confirm_password() {

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

    public function test_reset_not_min_password() {

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
