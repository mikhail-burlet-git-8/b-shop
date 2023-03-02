<?php

namespace App\View\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Spatie\ViewModels\ViewModel;

class CatalogViewModel extends ViewModel {
    public function __construct( public Category $category ) {
        //
    }


    public function categories() {
        return CategoryViewModel::make()->catalogPage();
    }

    public function products() {
        return Product::query()
                      ->select( [
                          'id',
                          'title',
                          'slug',
                          'price',
                          'old_price',
                          'thumbnail',
                          'brand_id',
                          'json_properties'
                      ] )->withCategory( $this->category )->search()
                      ->filtered()->sorted()->paginate();
    }
}
