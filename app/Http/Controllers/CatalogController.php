<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller {
    public function __invoke(): Factory|View|Application {

        $categories = CategoryViewModel::make()->catalogPage();
        $products   = Product::query()->get();

        return view( 'catalog', compact( [
            'categories',
            'products',
        ] ) );
    }
}
