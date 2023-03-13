<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory {
    public function definition() {
        return [
            'name'   => $this->faker->name,
            'text'   => $this->faker->realText,
            'active' => true
        ];
    }
}
