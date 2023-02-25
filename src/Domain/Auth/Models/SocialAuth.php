<?php

namespace Domain\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialAuth extends Model {
    use HasFactory;

    protected $fillable = [ 'social_id', 'driver' ];

    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }
}
