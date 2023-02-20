<?php

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase {
    use RefreshDatabase;

    public function test_get_image(): void {

        $size    = '998x997';
        $method  = 'resize';
        $storage = Storage::disk( 'images' );
        $product = ProductFactory::new()->createOne();

        config()->set( 'thumbnail', [ 'allowed_sizes' => [ $size ] ] );

        $response = $this->get( $product->makeThumbnail( $size, $product->id, $method ) );

        $response->assertOk();

        $storage->assertExists( "products/$product->id/$method/$size/" . File::basename( $product->thumbnail ) );

    }

}

