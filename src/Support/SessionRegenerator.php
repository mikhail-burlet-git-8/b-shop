<?php

namespace Support;

use App\Events\AfterSessionRegenrate;
use Closure;

class SessionRegenerator {
    public static function run( Closure $callback = null ): void {
        $old = request()->session()->getId();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if ( ! is_null( $callback ) ) {
            $callback();
        }

        event( new AfterSessionRegenrate(
            $old,
            request()->session()->getId()
        ) );
    }
}
