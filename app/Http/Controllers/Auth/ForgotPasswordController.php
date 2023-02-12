<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotFormRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller {
    public function page(): Factory|View|Application {
        return view( 'auth.forgot-password' );
    }

    public function handle( ForgotFormRequest $request ): RedirectResponse {

        $status = Password::sendResetLink(
            $request->only( 'email' )
        );

        if ( $status === Password::RESET_LINK_SENT ) {
            flash()->info( 'Письмо с инструкциями отправлено на ваш почтовый ящик' );

            return back();
        }

        flash()->alert( 'Произошла ошибка' );

        return back();

    }

}
