<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SignUpController;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SignUpControllerTest extends TestCase {
    use RefreshDatabase;

    protected array $request;

    protected function setUp(): void {
        parent::setUp();
        $this->request = [
            'name'                  => 'Test Name',
            'email'                 => 'mihail.burlet@gmail.com',
            'password'              => 'Password5490',
            'password_confirmation' => 'Password5490',
        ];
    }

    public function test_store_success(): void {
        Event::fake();


        $this->assertDatabaseMissing( 'users', [ 'email' => $this->request['email'] ] );

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $this->request
        );
        $response->assertValid();

        $this->assertDatabaseHas( 'users', [ 'email' => $this->request['email'] ] );

        $user = User::query()->where( 'email', $this->request['email'] )->first();

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

    public function test_store_not_valid(): void {

        $this->request['password'] = 'Pass';
        $this->request['email']    = 'mihail.burlet@gmail123123.com';

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $this->request
        );
        $response->assertInvalid( [ "email", "password", ] );
    }

    public function test_store_user_exist(): void {

        UserFactory::new()->create( [
            'name'  => 'Test Name',
            'email' => 'mihail.burlet@gmail.com',
        ] );

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $this->request
        );

        $response->assertInvalid( [ "email" ] );
    }

    public function test_store_not_min_password(): void {

        $this->request['password']              = 'Pass';
        $this->request['password_confirmation'] = 'Pass';

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $this->request
        );

        $response->assertInvalid( [ "password" ] );
    }


    public function test_store_not_confirmed_password(): void {

        $this->request['password_confirmation'] = 'Password549';

        $response = $this->post(
            action( [ SignUpController::class, 'handle' ] ),
            $this->request
        );

        $response->assertInvalid( [ "password" ] );
    }

    public function test_signup_page_success(): void {
        $this->get( action( [ SignUpController::class, 'page' ] ) )
             ->assertOk()
             ->assertSee( 'Регистрация' )
             ->assertViewIs( 'auth.sign-up' );
    }

}
