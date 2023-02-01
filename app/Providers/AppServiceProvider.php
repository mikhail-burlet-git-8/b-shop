<?php

namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {

        Model::shouldBeStrict( ! app()->isProduction() );

        if ( app()->isProduction() ) {
            DB::listen( function ( $query ) {
                if ( $query->time > 100 ) {
                    logger()
                        ->channel( 'telegram' )
                        ->debug( 'whenQueryingForLongerThan: ' . $query->sql, $query->bindings );
                }

                dump( $query->time );
            } );

            app( Kernel::class )->whenRequestLifecycleIsLongerThan(
                CarbonInterval::second( 4 ),
                function () {
                    logger()
                        ->channel( 'telegram' )
                        ->debug( 'whenRequestLifecycleIsLongerThan: ' . request()->url() );
                }
            );
        }

    }
}
