<?php

namespace Domain\Catalog\Sorters;


use Illuminate\Database\Eloquent\Builder;

final class Sorter {
    public const SORT_KEY = 'sort';

    public function __construct(
        protected array $columns = []
    ) {
    }

    public function run( Builder $query ) {
        $sortData = $this->sortData();

        return $query->when( $sortData->contains( $this->columns() ), function ( $q ) use ( $sortData ) {
            $q->orderBy(
                (string) $sortData->remove( '-' ),
                $sortData->contains( '-' ) ? 'DESC' : 'ASC'
            );
        } );
    }

    public function key(): string {
        return self::SORT_KEY;
    }

    public function sortData() {
        return request()->str( $this->key() );
    }

    public function columns(): array {
        return $this->columns;
    }

    public function isActive( string $column, string $direction = 'ASC' ): bool {
        $column = trim( $column, '-' );
        if ( strtoupper( $direction ) === 'DESC' ) {
            $column = '-' . $column;
        }

        return request( $this->key() ) === $column;
    }
}
