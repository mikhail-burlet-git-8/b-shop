<?php

namespace App\Http\Controllers;

use Domain\Post\Models\Post;
use Domain\Post\ViewModels\PostViewModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller {
    public function index() {
        $posts = PostViewModel::make()->all();

        return view( 'posts.posts', compact( 'posts' ) );
    }

    public function show( Post $post ): Factory|View|Application {
        if ( $post->status != 'published' ) {
            abort( 404 );
        }

        return view( 'posts.post', compact( 'post' ) );
    }
}
