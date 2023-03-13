<?php

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create( 'products', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'title' );
            $table->string( 'slug' )->unique();
            $table->string( 'thumbnail' )
                  ->nullable();
            $table->unsignedInteger( 'price' )
                  ->default( 0 );
            $table->unsignedInteger( 'quantity' )
                  ->default( 0 );
            $table->unsignedInteger( 'old_price' )
                  ->default( 0 );
            $table->unsignedInteger( 'purchase_price' )
                  ->default( 0 );
            $table->string( 'manufacturer_link' )
                  ->nullable();
            $table->foreignIdFor( Brand::class )
                  ->nullable()
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->timestamps();
        } );

        Schema::create( 'category_product', function ( Blueprint $table ) {
            $table->id();

            $table->foreignIdFor( Category::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->foreignIdFor( Product::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

        } );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        if ( ! app()->isProduction() ) {
            Schema::dropIfExists( 'category_product' );
            Schema::dropIfExists( 'products' );
        }
    }
};
