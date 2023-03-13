<?php

namespace App\Observers;

use Domain\Post\Models\Post;

class PostObserver {
    public function cacheForgetPosts(): void {
        cache()->forget( 'posts.home' );
        cache()->forget( 'posts' );
    }

    public function created(): void {
        $this->cacheForgetPosts();
    }

    public function updated(): void {
        $this->cacheForgetPosts();
    }

    public function deleted(): void {
        $this->cacheForgetPosts();
    }

}
