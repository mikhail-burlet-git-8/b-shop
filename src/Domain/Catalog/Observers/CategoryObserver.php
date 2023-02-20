<?php

namespace Domain\Catalog\Observers;

class CategoryObserver {

    public function __construct() {
        cache()->forget( 'category.home' );
    }

}
