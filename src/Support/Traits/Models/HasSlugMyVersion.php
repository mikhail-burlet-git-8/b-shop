<?php

namespace Support\Traits\Models;


use Illuminate\Database\Eloquent\Model;

trait HasSlugMyVersion {

    protected static function bootHasSlug(): void {
        static::creating( function ( Model $item ) {
            $item->slug = self::checkSlug( $item );
        } );
    }

    public static function checkSlug( $item, $index = 0 ): string {
        $slug = $item->slug ?? str( $item->{self::slugFrom()} )->slug();
        if ( $index > 0 ) {
            $slug .= '-' . $index;
        }
        if ( $item->where( 'slug', $slug )->exists() ) {
            $index ++;

            return self::checkSlug( $item, $index );
        }

        return $slug;
    }


    public static function slugFrom(): string {
        return 'title';
    }
}
