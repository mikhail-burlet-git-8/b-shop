<?php

namespace Domain\Post\ViewModels;

use Domain\Post\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Support\Traits\Makeable;

class PostViewModel {
    use Makeable;

    public function homePage() {
        return cache()->rememberForever( 'posts.home', function () {
            return Post::query()
                       ->where( 'status', 'published' )
                       ->homePage()
                       ->get();
        } );
    }

    public function all() {
        return Post::query()
                   ->where( 'status', 'published' )
                   ->paginate();
    }
}
