<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create( 'properties', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'title' );
            $table->timestamps();
        } );
        Schema::create( 'product_property', function ( Blueprint $table ) {
            $table->id();
            $table->foreignIdFor( \Domain\Product\Models\Product::class )
                  ->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor( \Domain\Product\Models\Property::class )
                  ->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string( 'value' );
        } );
    }

    public function down(): void {
        if ( ! app()->isProduction() ) {
            Schema::dropIfExists( 'properties' );
        }
    }
};
