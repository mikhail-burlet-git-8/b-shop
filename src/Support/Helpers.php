<?php


use Support\Flash\Flash;

if ( ! function_exists( '__money' ) ) {
    function __money( string $money, int $countDecimal = 2, string $symbol = '₽' ): string {
        return number_format( $money, $countDecimal, '.', ' ' ) . ' ' . $symbol;
    }
}
if ( ! function_exists( 'flash' ) ) {
    function flash(): Flash {
        return app( Flash::class );
    }
}
