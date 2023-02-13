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

class SignInControllerTest extends TestCase {
    use RefreshDatabase;

    public function test_it_login_page_success(): void {
        $this->get( action( [ SignInController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Вход в аккаунт' )
             ->assertViewIs( 'auth.login' );
    }

    public function test_it_logout_success(): void {
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


    public function test_it_sign_in_empty_form(): void {
        $response = $this->post( action( [ SignInController::class, 'handle' ] ), [] );

        $response->assertInvalid( [
            "email"    => "Поле обязательно для заполнения",
            "password" => "Поле обязательно для заполнения"
        ] );
    }

    public function test_it_sign_in_not_user(): void {
        $response = $this->post( action( [ SignInController::class, 'handle' ] ), [
            'email'    => 'mihail.burlet@gmail.com',
            'password' => 'password',
        ] );

        $response->assertInvalid( [
            "email" => "Предоставленные учетные данные не соответствуют нашим записям.",
        ] );
    }

    public function test_it_sign_in_not_valid_email(): void {

        $request = new SignInFormRequest( [
            'email'    => 'mihail.burlet@123123.com',
            'password' => 'password',
        ] );


        $response = $this->post( action( [ SignInController::class, 'handle' ], $request ) );

        $response->assertInvalid();
    }

}
