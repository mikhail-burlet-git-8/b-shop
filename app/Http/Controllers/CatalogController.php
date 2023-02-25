<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller {
    public function __invoke( ?Category $category ): Factory|View|Application {

        $categories = CategoryViewModel::make()->catalogPage();
        $brands     = BrandViewModel::make()->catalogPage();
        $products   = Product::query()
                             ->select( [ 'id', 'title', 'slug', 'price', 'thumbnail', 'brand_id' ] )
                             ->when( request( 'search' ), function ( Builder $query ) {
                                 $query->whereFullText( [ 'title', 'text' ], request( 'search' ) );
                             } )
                             ->when( $category->exists, function ( Builder $query ) use ( $category ) {
                                 $query->whereRelation(
                                     'categories',
                                     'categories.id',
                                     '=',
                                     $category->id );
                             } )
                             ->filtered()
                             ->sorted()
                             ->paginate();

        return view( 'catalog.catalog', compact( [
            'categories',
            'products',
            'brands',
            'category',
        ] ) );
    }
}
