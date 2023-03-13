<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase {
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        CartManager::fake();
    }

    public function test_is_empty_cart(): void {
        $this->get( action( [ CartController::class, 'index' ] ) )
             ->assertOk()
             ->assertViewIs( 'cart.cart' )
             ->assertViewHas( 'items', collect() );
    }

    public function test_is_not_empty_cart(): void {
        $product = ProductFactory::new()->createOne();

        cart()->add( $product, 4 );

        $this->get( action( [ CartController::class, 'index' ] ) )
             ->assertOk()
             ->assertViewIs( 'cart.cart' )
             ->assertViewHas( 'items', cart()->items() );
    }

    public function test_added_success(): void {
        $product = ProductFactory::new()->createOne();

        $this->assertEquals( 0, cart()->count() );

        $this->post(
            action( [ CartController::class, 'add' ], $product ),
            [ 'quantity' => 4 ]
        );

        $this->assertEquals( 4, cart()->count() );
    }


    public function test_quantity_change(): void {
        $product = ProductFactory::new()->createOne();

        cart()->add( $product, 4 );

        $this->assertEquals( 4, cart()->count() );

        $this->post(
            action( [ CartController::class, 'quantity' ], $product ),
            [ 'quantity' => 8 ]
        );

        $this->assertEquals( 8, cart()->count() );
    }

    public function test_delete_cart_item(): void {
        $product = ProductFactory::new()->createOne();

        cart()->add( $product );

        $this->assertEquals( 1, cart()->count() );

        $this->delete(
            action( [ CartController::class, 'delete' ], cart()->cartItems()->first() ), );


        $this->assertEquals( 0, cart()->count() );
    }

    public function test_clear_cart(): void {
        $product = ProductFactory::new()->createOne();

        cart()->add( $product );

        $this->assertEquals( 1, cart()->count() );

        $this->delete(
            action( [ CartController::class, 'clear' ] ), );


        $this->assertEquals( 0, cart()->count() );
    }


}
