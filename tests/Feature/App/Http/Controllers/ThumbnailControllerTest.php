<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
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


    }

}

