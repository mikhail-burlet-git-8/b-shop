<?php

namespace App\Observers;

use Domain\Post\Models\Post;

class PostObserver {


    public function created(): void {
        __cacheForget( 'posts' );
    }

    public function updated( Post $post ): void {
        __cacheForget( 'posts', $post->slug );
    }

    public function deleted( Post $post ): void {
        __cacheForget( 'posts', $post->slug );
    }

}
