<?php

namespace App\Providers;

use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
use Services\Telegram\TelegramBotApiFake;
use Support\Testing\FakerImageProvider;

class AppServiceProvider extends ServiceProvider {

    public function register(): void {
        $this->app->singleton( Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider( new FakerImageProvider( $faker ) );

            return $faker;
        } );
    }

    public function boot(): void {

        $this->app->bind( TelegramBotApiContract::class, TelegramBotApi::class );

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
