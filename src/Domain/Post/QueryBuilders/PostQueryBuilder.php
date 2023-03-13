<?php

namespace Domain\Post\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder {
    public function homePage(): PostQueryBuilder {
        return $this->select( [ 'id', 'title', 'slug', 'thumbnail', 'short_text' ] )
                    ->where( 'on_home_page', true )
                    ->limit( 6 );
    }
}
