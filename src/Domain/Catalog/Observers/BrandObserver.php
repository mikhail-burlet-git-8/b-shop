<?php

namespace Domain\Catalog\Observers;


class BrandObserver {
    public function __construct() {
        cache()->forget( 'brand.home' );
    }
}
