<?php

namespace App\Providers;

use App\Faker\FakerImageProvider;
use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    public function register(): void {
        $this->app->singleton( Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider( new FakerImageProvider( $faker ) );

            return $faker;
        } );
    }

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
