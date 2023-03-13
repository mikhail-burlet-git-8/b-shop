<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create( 'comments', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' )->nullable();
            $table->string( 'text' );
            $table->boolean( 'active' )->default( false );
            $table->integer( 'user_id' )->nullable();
            $table->integer( 'commentable_id' );
            $table->string( 'commentable_type' );
            $table->timestamps();
        } );
    }

    public function down(): void {
        if ( ! app()->isProduction() ) {
            Schema::dropIfExists( 'comments' );
        }
    }
};
