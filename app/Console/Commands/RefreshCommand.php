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

        Storage::deleteDirectory( '/storage/images/products' );

        $this->call( 'migrate:fresh', [
            '--seed' => true,
        ] );

        return self::SUCCESS;
    }
}
