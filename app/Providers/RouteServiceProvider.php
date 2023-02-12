<?php

namespace App\Providers;

use App\Contracts\RouteRegistrar;
use App\Routing\AppRegistrar;
use Domain\Auth\Routing\AuthRegistrar;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class RouteServiceProvider extends ServiceProvider {

    public const HOME = '/';

    protected array $registrars = [
        AppRegistrar::class,
        AuthRegistrar::class,
    ];

    public function boot(): void {
        $this->configureRateLimiting();

        $this->routes( function ( Registrar $router ) {
            $this->mapRoutes( $router, $this->registrars );
        } );
    }


    protected function configureRateLimiting(): void {

        // Глобальный рейт лимит, задается либо в роутах, либо в kernel.php

        RateLimiter::for( 'global', function ( Request $request ) {
            return Limit::perMinute( 500 )
                        ->by( $request->user()?->id ?: $request->ip() )
                        ->response( function ( Request $request, array $headers ) {
                            return response( 'Take it easy', Response::HTTP_TOO_MANY_REQUESTS, $headers );
                        } );
        } );

        RateLimiter::for( 'auth', function ( Request $request ) {
            return Limit::perMinute( 100 )->by( $request->ip() );
        } );

        RateLimiter::for( 'api', function ( Request $request ) {
            return Limit::perMinute( 60 )->by( $request->user()?->id ?: $request->ip() );
        } );
    }

    protected function mapRoutes( Registrar $router, array $registrars ) {
        foreach ( $registrars as $registrar ) {
            if ( ! class_exists( $registrar ) || is_subclass_of( $registrar, RouteRegistrar::class ) ) {
                throw new RuntimeException( sprintf(
                    'Cannot map routes \'%s\', it is not a valid routes class',
                    $registrar
                ) );
            }

            ( new $registrar )->map( $router );

        }
    }

}