<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create( 'posts', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'title' );
            $table->string( 'slug' )->unique();
            $table->boolean( 'on_home_page' )->default( false );
            $table->string( 'thumbnail' )->unique();
            $table->text( 'text' )->nullable();
            $table->string( 'status' )->default( 'published' );
            $table->text( 'short_text' )->nullable();
            $table->timestamps();
        } );
    }

    public function down(): void {
        if ( ! app()->isProduction() ) {
            Schema::dropIfExists( 'posts' );
        }
    }
};
