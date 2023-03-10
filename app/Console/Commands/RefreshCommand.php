<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command {

    protected $signature = 'shop:refresh';

    public function handle() {
        if ( app()->isProduction() ) {
            return self::FAILURE;
        }

        Storage::deleteDirectory( 'images' );

        $this->call( 'cache:clear' );

        $this->call( 'migrate:fresh', [
            '--seed' => true,
        ] );

        sleep( 5 );

        $this->call( 'queue:work', [
            '--stop-when-empty' => true
        ] );

        return self::SUCCESS;
    }
}
