<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\SocialAuth;
use Domain\Auth\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller {
    public function redirect( string $driver ): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse {
        try {
            return Socialite::driver( $driver )->redirect();
        } catch ( Throwable $e ) {
            throw new DomainException( 'Произошла ошибка или драйвер не поддерживается' );
        }
    }

    public function callback( string $driver ): RedirectResponse {

        $allowed_driver = [
            'vkontakte',
            'github',
        ];

        if ( ! in_array( $driver, config( 'auth.allowed_driver' ) ) ) {
            throw new DomainException( 'Драйвер не поддерживается' );
        }

        $socialUser = Socialite::driver( $driver )->user();

        $socialId = SocialAuth::query()
                              ->where( 'social_id', $socialUser->getId() )
                              ->first();

        if ( $socialId ) {
            $user = $socialId->user;

            auth()->login( $user );

            return redirect()->intended( route( 'home' ) );
        }

        $user = User::query()->create( [
            'name'     => $socialUser->getName() ?? $socialUser->getNickname() ?? $socialUser->getId(),
            'email'    => $socialUser->getEmail(),
            'password' => bcrypt( str()->random( 20 ) ),
        ] );

        $user->social()->create( [
            'social_id' => $socialUser->getId(),
            'driver'    => $driver,
        ] );

        auth()->login( $user );

        return redirect()->intended( route( 'home' ) );
    }

}
