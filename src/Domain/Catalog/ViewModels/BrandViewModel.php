<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Support\Traits\Makeable;

class BrandViewModel {
    use Makeable;

    public function homePage(): BrandCollection|array {
        return cache()->rememberForever( 'brand.home', function () {
            return Brand::query()->homePage()->get();
        } );
    }
}
