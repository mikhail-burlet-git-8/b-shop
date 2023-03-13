<?php

namespace App\Models;

use Domain\Post\Models\Post;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'text',
        'user_id',
        'commentable_id',
        'commentable_type',
    ];

    public function commentable() {
        $this->morphTo( '', '', '', '' );
    }

}
