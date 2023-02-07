<?php

namespace App\Traits\Models;


use Illuminate\Database\Eloquent\Model;

trait HasSlug {

    protected static function bootHasSlug(): void {
        static::creating( function ( Model $item ) {
            $item->makeSlug();
        } );
    }

    protected function makeSlug(): void {
        $slug = $this->slugUnique(
            str( $this->{$this->slugFrom()} )->slug()->value()
        );

        $this->{$this->slugColumn()} = $this->{$this->slugColumn()} ?? $slug;
    }

    private function slugUnique( string $slug ): string {

        $originalSlug = $slug;
        $index        = 0;

        while ( $this->isSlugExists( $slug ) ) {
            $index ++;

            $slug = $originalSlug . '-' . $index;
        }

        return $slug;
    }

    private function isSlugExists( string $slug ): string {

        $query = $this->newQuery()
                      ->where( self::slugColumn(), $slug )
                      ->where( $this->getKeyName(), '!=', $this->getKey() )
                      ->withoutGlobalScopes();

        return $query->exists();
    }

    public static function slugFrom(): string {
        return 'title';
    }

    public static function slugColumn(): string {
        return 'slug';
    }
}
