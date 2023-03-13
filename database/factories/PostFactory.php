<?php

namespace Database\Factories;

use Domain\Post\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Post\Models\Post>
 */
class PostFactory extends Factory {

    protected $model = Post::class;

    public function definition() {
        return [
            'title'        => ucfirst( $this->faker->words( 2, true ) ),
            'thumbnail'    => $this->faker->fixturesImage( 'products', 'posts' ),
            'on_home_page' => $this->faker->boolean(),
            'status'       => 'published',
            'text'         => $this->faker->realText(),
            'short_text'   => $this->faker->text( 100 ),
        ];
    }
}
