<?php

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

final class Price implements Stringable {
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 100,
    ) {
        if ( $value < 0 ) {
            throw new InvalidArgumentException( 'Цена должна быть больше нуля' );
        }
        if ( ! isset( $this->currencies[ $this->currency ] ) ) {
            throw new InvalidArgumentException( 'Нет такой валюты' );
        }

    }

    public function raw(): int {
        return $this->value;
    }

    public function value(): float|int {
        return $this->value / $this->precision;
    }

    public function currency(): string {
        return $this->currency;
    }

    public function symbol(): string {
        return $this->currencies[ $this->currency ];
    }

    public function __toString() {
        return number_format( $this->value(), 0, ',', ' ' )
               . ' ' . $this->symbol();
    }
}
