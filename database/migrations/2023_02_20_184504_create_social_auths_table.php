<?php

use Domain\Auth\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create( 'social_auths', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'driver' );
            $table->string( 'social_id' );

            $table->foreignIdFor( User::class )
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->timestamps();
        } );
    }

    public function down(): void {
        if ( ! app()->isProduction() ) {
            Schema::dropIfExists( 'social_auths' );
        }
    }
};
