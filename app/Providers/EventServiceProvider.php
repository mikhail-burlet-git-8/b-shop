<?php

namespace App\Providers;

use App\Events\AfterSessionRegenrate;
use App\Listeners\SendEmailNewUserListener;
use Domain\Cart\CartManager;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Observers\BrandObserver;
use Domain\Catalog\Observers\CategoryObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\VKontakte\VKontakteExtendSocialite;

class EventServiceProvider extends ServiceProvider {
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class         => [
            SendEmailVerificationNotification::class,
            SendEmailNewUserListener::class,
        ],
        SocialiteWasCalled::class => [
            VKontakteExtendSocialite::class . '@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() {
        Event::listen( AfterSessionRegenrate::class, function ( AfterSessionRegenrate $event ) {
            cart()->updateStorageId( $event->old, $event->current );
        } );
        Category::observe( CategoryObserver::class );
        Brand::observe( BrandObserver::class );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents() {
        return false;
    }
}
