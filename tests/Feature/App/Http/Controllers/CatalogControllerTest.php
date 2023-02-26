<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CatalogController;
use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Tests\TestCase;

class CatalogControllerTest extends TestCase {


    public function test_sorting_price_and_price_filtered(): void {
        $productLowPrice  = ProductFactory::new()->createOne( [
            'price' => 100,
        ] );
        $productHighPrice = ProductFactory::new()->createOne( [
            'price' => 1000,
        ] );
        $this->get( action( [ CatalogController::class ], [ 'sort' => '-price' ] ) )
             ->assertViewHas( 'products.0', $productHighPrice )
             ->assertViewHas( 'products.1', $productLowPrice );

        $this->get( action( [ CatalogController::class ], [ 'sort' => 'price' ] ) )
             ->assertViewHas( 'products.0', $productLowPrice )
             ->assertViewHas( 'products.1', $productHighPrice );
    }

    public function test_status(): void {
        BrandFactory::new()->count( 10 )->create();
        CategoryFactory::new()->count( 10 )
                       ->has( Product::factory( rand( 10, 30 ) ) )
                       ->create();

        $response = $this->get( action( [ CatalogController::class ] ) );
        $response
            ->assertViewHas( 'brands.0' )
            ->assertViewHas( 'products.0' )
            ->assertViewHas( 'categories.0' );
    }


    public function test_sorting_title(): void {
        $product_1 = ProductFactory::new()->createOne( [
            'title' => '1 product',
        ] );
        $product_2 = ProductFactory::new()->createOne( [
            'title' => '9 product',
        ] );


        $this->get( action( [ CatalogController::class ], [ 'sort' => 'title' ] ) )
             ->assertViewHas( 'products.0', $product_1 )
             ->assertViewHas( 'products.1', $product_2 );
    }

    public function test_category(): void {

        $category = CategoryFactory::new()->createOne();

        $this->get( action( [ CatalogController::class ], [ 'category' => $category->slug ] ) )
             ->assertViewHas( 'category', $category );
    }

    public function test_brand_filtered(): void {
        $brand = BrandFactory::new()->createOne();

        $productLowPrice = ProductFactory::new()->createOne( [ 'brand_id' => $brand->id ] );

        $this->get( action( [ CatalogController::class ], [
            'filters' => [
                'brands' => [ $brand->id => $brand->id ],
            ]
        ] ) )->assertViewHas( 'products.0', $productLowPrice );
    }


}
