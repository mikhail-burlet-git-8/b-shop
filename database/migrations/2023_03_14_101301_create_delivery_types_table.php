<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create( 'delivery_types', function ( Blueprint $table ) {
            $table->id();

            $table->string( 'title' );
            $table->string( 'description' );

            $table->unsignedBigInteger( 'price' )
                  ->default( 0 );

            $table->boolean( 'with_address' )
                  ->default( false );

            $table->timestamps();
        } );

        DB::table( 'delivery_types' )->insert( [
            'title'        => 'Доставка по Симферополю',
            'description'  => 'Доставим Ваш заказ по г. Симферополь',
            'with_address' => true
        ] );
        DB::table( 'delivery_types' )->insert( [
            'title'        => 'Boxberry',
            'description'  => 'Доставка до пункта выдачи по России с оплатой на сайте',
            'with_address' => false
        ] );
        DB::table( 'delivery_types' )->insert( [
            'title'        => 'Boxberry наложенным платежом',
            'description'  => 'Доставка до пункта выдачи по России с оплатой при получении',
            'with_address' => false
        ] );
    }

    public function down(): void {
        if ( ! app()->isProduction() ) {
            Schema::dropIfExists( 'delivery_types' );
        }
    }
};
