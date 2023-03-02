<?php

namespace Domain\Product\Collections;


use Illuminate\Database\Eloquent\Collection;

final class PropertiesCollection extends Collection {
    public function keyValues() {
        return $this->product->properties
            ->mapWithKeys( fn( $property ) => [ $property->title => $property->pivot->value ] );
    }
}
