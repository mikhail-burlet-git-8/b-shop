<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotFormRequest;
use App\Http\Requests\PasswordResetFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller {
    public function login() {
        return view( 'auth.login' );
    }

    public function signUp() {
        return view( 'auth.sign-up' );
    }

    public function resetPassword() {
        return view( 'auth.reset-password' );
    }

    public function forgot() {
        return view( 'auth.forgot-password' );
    }

    public function reset( string $token ): Application|Factory|View {
        return view( 'auth.reset-password', [ 'token' => $token ] );
    }

    public function logOut(): RedirectResponse {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route( 'home' );
    }

    public function signIn( SignInFormRequest $request ): RedirectResponse {

        if ( ! auth()->attempt( $request->validated() ) ) {
            return back()->withErrors( [
                'email' => 'Предоставленные учетные данные не соответствуют нашим записям.',
            ] )->onlyInput( 'email' );
        }

        $request->session()->regenerate();

        return redirect()->intended( route( 'home' ) );

    }

    public function store( SignUpFormRequest $request ): RedirectResponse {

        $user = User::create( [
            'name'     => $request->get( 'name' ),
            'email'    => $request->get( 'email' ),
            'password' => bcrypt( $request->get( 'password' ) ),
        ] );

        auth()->login( $user );

        event( new Registered( $user ) );

        return redirect()->intended( route( 'home' ) );
    }


    public function forgotPassword( ForgotFormRequest $request ): RedirectResponse {
        $status = Password::sendResetLink(
            $request->only( 'email' )
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with( [ 'message' => __( $status ) ] )
            : back()->withErrors( [ 'email' => __( $status ) ] );
    }


    public function passwordReset( PasswordResetFormRequest $request ): RedirectResponse {

        $status = Password::reset(
            $request->only( 'email', 'password', 'password_confirmation', 'token' ),
            function ( $user, $password ) {
                $user->forceFill( [
                    'password' => bcrypt( $password )
                ] )->setRememberToken( str()->random( 20 ) );

                $user->save();

                event( new PasswordReset( $user ) );
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route( 'login' )->with( 'message', __( $status ) )
            : back()->withErrors( [ 'email' => [ __( $status ) ] ] );

    }

    public function github(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse {
        return Socialite::driver( 'github' )->redirect();
    }

    public function githubCallback(): RedirectResponse {
        $githubUser = Socialite::driver( 'github' )->user();

        $user = User::query()->updateOrCreate( [
            'github_id' => $githubUser->id,
        ], [
            'name'     => $githubUser->name ?? $githubUser->id,
            'email'    => $githubUser->email,
            'password' => bcrypt( str()->random( 20 ) ),
        ] );

        auth()->login( $user );

        return redirect()->intended( route( 'home' ) );
    }
}
