<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory {
    public function definition(): array {
        return [
            'title'        => ucfirst( $this->faker->words( 2, true ) ),
            'price'        => $this->faker->numberBetween( 1000, 100000 ),
            'brand_id'     => Brand::query()->inRandomOrder()->value( 'id' ),
            'thumbnail'    => $this->faker->fixturesImage( 'products', 'products' ),
            //'thumbnail'    => $this->faker->loremflickr( 'images/products' ),
            'on_home_page' => $this->faker->boolean(),
            'sorting'      => $this->faker->numberBetween( 1, 900 ),
            'text'         => $this->faker->realText(),
        ];
    }
}
