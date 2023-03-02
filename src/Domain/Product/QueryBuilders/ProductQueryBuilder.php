<?php

namespace Domain\Product\QueryBuilders;

use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder {
    public function homePage(): ProductQueryBuilder {
        return $this->where( 'on_home_page', true )
                    ->orderBy( 'sorting' )
                    ->limit( 8 );
    }

    public function filtered() {
        return app( Pipeline::class )
            ->send( $this )->through( filters() )->thenReturn();
    }

    public function sees( $productId ): ProductQueryBuilder {
        return $this->whereIn( 'id', session( 'sees' ) )
                    ->where( 'id', '!=', $productId )
                    ->limit( 4 );
    }

    public function withCategory( Category $category ) {
        return $this->when( $category->exists, function ( Builder $query ) use ( $category ) {
            $query->whereRelation(
                'categories',
                'categories.id',
                '=',
                $category->id );
        } );
    }

    public function search() {
        return $this->when( request( 'search' ), function ( Builder $query ) {
            $query->whereFullText( [ 'title', 'text' ], request( 'search' ) );
        } );
    }

    public function sorted(): \Illuminate\Contracts\Database\Query\Builder {
        return Sorter::run( $this );
    }
}
