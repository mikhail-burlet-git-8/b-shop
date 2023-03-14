<?php

namespace Domain\Catalog\ViewModels;

use Domain\Product\Models\Product;
use Support\Traits\Makeable;

class ProductViewModel {
    use Makeable;

    public function homePage() {
        return cache()->rememberForever( 'products.home', function () {
            return Product::query()
                          ->homePage()
                          ->get();
        } );
    }
}
