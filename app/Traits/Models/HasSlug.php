<?php

namespace App\Traits\Models;


use Illuminate\Database\Eloquent\Model;

trait HasSlug {

    protected static function bootHasSlug(): void {
        static::creating( function ( Model $item ) {
            $slug       = $item->slug ?? str( $item->{self::slugFrom()} )->slug();
            $item->slug = self::checkSlug( $item, $slug );
        } );
    }

    public static function checkSlug( $item, $slug, $index = 0 ): string {

        if ( $item->where( 'slug', $slug )->exists() ) {
            $index ++;
            $slug .= '-' . $index;
            
            return self::checkSlug( $item, $slug, $index );
        }

        return $slug;
    }


    public static function slugFrom(): string {
        return 'title';
    }
}
