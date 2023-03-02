<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CatalogViewMiddleware {
    public function handle( Request $request, Closure $next ) {

        $view = $request->get( 'view' );

        if ( $view ) {
            $request->session()->put( 'view', $view );
        }

        return $next( $request );
    }
}
