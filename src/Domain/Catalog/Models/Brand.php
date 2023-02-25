<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @method static Brand|BrandQueryBuilder query()
 */
class Brand extends Model {
    use HasFactory;
    use HasThumbnail;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    public function newEloquentBuilder( $query ): BrandQueryBuilder {
        return new BrandQueryBuilder( $query );
    }

    public function products(): HasMany {
        return $this->hasMany( Product::class );
    }

    protected function thumbnailDir(): string {
        return 'brands';
    }

    protected static function newFactory(): BrandFactory {
        return BrandFactory::new();
    }
}
