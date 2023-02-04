<?php

if ( ! function_exists( '__money' ) ) {
    function __money( string $money, int $countDecimal = 2, string $symbol = '₽' ): string {
        return number_format( $money, $countDecimal, '.', ' ' ) . ' ' . $symbol;
    }
}
