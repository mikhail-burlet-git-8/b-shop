<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\CommentFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PostFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Domain\Post\Models\Post;
use Domain\Product\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void {
        BrandFactory::new()->count( 10 )->create();
        $properties = PropertyFactory::new()->count( 5 )->create();

        OptionFactory::new()->count( 2 )->create();

        $optionValues = OptionValueFactory::new()->count( 10 )->create();


        CategoryFactory::new()->count( 10 )
                       ->has(
                           ProductFactory::new()->count( rand( 10, 30 ) )
                                         ->hasAttached( $optionValues )
                                         ->hasAttached( $properties, function () {
                                             return [ 'value' => ucfirst( fake()->word() ) ];
                                         } )
                                         ->afterCreating( function ( Product $product ) {
                                             CommentFactory::new()->count( 3 )->create( [
                                                 'commentable_id'   => $product->id,
                                                 'commentable_type' => 'product'
                                             ] );
                                         } ) )->create();
        PostFactory::new()->count( 30 )
                   ->afterCreating( function ( Post $post ) {
                       CommentFactory::new()->count( 3 )->create( [
                           'commentable_id'   => $post->id,
                           'commentable_type' => 'post'
                       ] );
                   } )->create();

    }
}
