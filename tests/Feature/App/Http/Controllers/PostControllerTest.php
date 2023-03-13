<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\PostController;
use Database\Factories\PostFactory;
use Tests\TestCase;

class PostControllerTest extends TestCase {
    public function test_page_posts(): void {
        PostFactory::new()->count( 10 )->create();
        $this->get( action( [ PostController::class, 'index' ] ) )
             ->assertOk()
             ->assertViewHas( 'posts.0' )
             ->assertViewIs( 'posts.posts' );
    }

    public function test_page_post(): void {
        $post = PostFactory::new()->createOne();
        $this->get( action( [ PostController::class, 'show' ], $post ) )
             ->assertOk()
             ->assertViewHas( 'post', $post )
             ->assertViewIs( 'posts.post' );
    }

    public function test_page_post_not_published(): void {
        $post = PostFactory::new()->createOne( [
            'status' => 'cart'
        ] );
        $this->get( action( [ PostController::class, 'show' ], $post ) )
             ->assertNotFound();
    }
}
