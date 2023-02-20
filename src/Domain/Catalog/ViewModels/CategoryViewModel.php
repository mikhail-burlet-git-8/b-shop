<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\Models\Category;
use Support\Traits\Makeable;

class CategoryViewModel {
    use Makeable;

    public function homePage(): CategoryCollection|array {
        return cache()->rememberForever( 'category.home', function () {
            return Category::query()->homePage()->get();
        } );
    }

    public function catalogPage(): CategoryCollection|array {
        return cache()->rememberForever( 'category.catalog', function () {
            return Category::query()->catalogPage()->get();
        } );
    }
}
