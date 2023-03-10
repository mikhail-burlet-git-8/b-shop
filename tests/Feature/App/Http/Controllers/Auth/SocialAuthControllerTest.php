<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialAuthController;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase {
    use RefreshDatabase;

    private function mockSocialiteCallback( string|int $githubId ): MockInterface {
        $user = $this->mock( SocialiteUser::class, function ( MockInterface $mock ) use ( $githubId ) {
            $mock->shouldReceive( 'getId' )->andReturn( $githubId );
            $mock->shouldReceive( 'getName' )->once()->andReturn( str()->random( 10 ) );
            $mock->shouldReceive( 'getEmail' )->once()->andReturn( 'mihail.burlet@gmail.com' );
        } );

        Socialite::shouldReceive( 'driver->user' )->once()->andReturn( $user );

        return $user;
    }

    private function callbackRequest(): TestResponse {
        return $this->get( action( [ SocialAuthController::class, 'callback' ], [ 'driver' => 'github' ] ) );
    }

    public function test_github_redirect_success(): void {
        $this->get( action( [ SocialAuthController::class, 'redirect' ], [ 'driver' => 'github' ] ) )
             ->assertRedirectContains( 'github.com' );
    }

    public function test_vk_redirect_success(): void {
        $this->get( action( [ SocialAuthController::class, 'redirect' ], [ 'driver' => 'vkontakte' ] ) )
             ->assertRedirectContains( 'vk.com' );
    }

    public function test_driver_not_found_exception(): void {
        $this->expectException( DomainException::class );

        $this->withoutExceptionHandling()->get( action(
            [ SocialAuthController::class, 'redirect' ],
            [ 'driver' => 'vk' ]
        ) );
        $this->withoutExceptionHandling()->get( action(
            [ SocialAuthController::class, 'callback' ],
            [ 'driver' => 'vk' ]
        ) );
    }

    public function test_github_callback_created_user_success(): void {
        $socialId = str()->random( 10 );

        $this->assertDatabaseMissing( 'social_auths', [ 'social_id' => $socialId ] );

        $this->mockSocialiteCallback( $socialId );

        $user = $this->callbackRequest();

        $user->assertRedirect( route( 'home' ) );

        $this->assertAuthenticated();

        $this->assertDatabaseHas( 'social_auths', [ 'social_id' => $socialId ] );
    }


}
