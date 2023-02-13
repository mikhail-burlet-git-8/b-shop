<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
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

class SocialAuthControllerTest extends TestCase {
    use RefreshDatabase;

//
//    public function test_it_store_not_valid(): void {
//
//        $response = $this->post( action( [ SocialAuthController::class, 'callback' ], 'github' ) );
//
//        $response->assertRedirect( route( 'login.page' ) );
//    }
}
