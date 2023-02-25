<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\Models\Brand;
use Support\Traits\Makeable;

class BrandViewModel {
    use Makeable;

    public function homePage() {
        return cache()->rememberForever( 'brand.home', function () {
            return Brand::query()
                        ->homePage()
                        ->get();
        } );
    }

    public function catalogPage() {
        return cache()->rememberForever( 'brand.catalog', function () {
            return Brand::query()
                        ->select( [ 'thumbnail', 'id', 'title' ] )
                        ->has( 'products' )
                        ->catalogPage()
                        ->get();
        } );
    }

}
