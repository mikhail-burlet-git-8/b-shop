<?php

namespace Domain\Post\Models;

use App\Models\Comment;
use Domain\Post\QueryBuilders\PostQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Post extends Model {
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'title',
        'text',
        'thumbnail',
        'title',
        'slug',
    ];

    public function comments() {
        $this->morphMany( Comment::class, 'commentable' );
    }

    protected function thumbnailDir(): string {
        return 'posts';
    }

    public function newEloquentBuilder( $query ): PostQueryBuilder {
        return new PostQueryBuilder( $query );
    }
}
