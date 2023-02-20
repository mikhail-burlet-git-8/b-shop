<?php

namespace App;

use Iterator;

class Menu implements Iterator {
    protected $item = [
        'Главная'         => '/',
        'Каталог товаров' => '/catalog',
        'Корзина'         => '/cart'
    ];

    public function current(): mixed {
        // TODO: Implement current() method.
    }

    public function next(): void {
        // TODO: Implement next() method.
    }

    public function key(): mixed {
        // TODO: Implement key() method.
    }

    public function valid(): bool {
        // TODO: Implement valid() method.
    }

    public function rewind(): void {
        // TODO: Implement rewind() method.
    }
}
