<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\Models\Category;
use Support\Traits\Makeable;

class CategoryViewModel {
    use Makeable;

    public function homePage() {
        return cache()->rememberForever( 'category.home', function () {
            return Category::query()
                           ->homePage()
                           ->get();
        } );
    }

    public function catalogPage() {
        return cache()->rememberForever( 'category.catalog', function () {
            return Category::query()
                           ->select( [ 'thumbnail', 'id', 'title' ] )
                           ->has( 'products' )
                           ->catalogPage()
                           ->get();
        } );
    }
}
