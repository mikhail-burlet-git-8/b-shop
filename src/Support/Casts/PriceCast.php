<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Support\ValueObjects\Price;

class PriceCast implements CastsAttributes {

    public function get( $model, string $key, $value, array $attributes ) {
        return Price::make( $value );
    }

    public function set( $model, string $key, $value, array $attributes ) {
        if ( ! $value instanceof Price ) {
            $value = Price::make( $value );
        }

        return $value->raw();
    }
}
