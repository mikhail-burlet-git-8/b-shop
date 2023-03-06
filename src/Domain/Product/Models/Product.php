<?php

namespace Domain\Product\Models;

use App\Filters\Sorting;
use App\Jobs\ProductJsonProperties;
use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Product extends Model {
    use HasFactory;
    use HasThumbnail;
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'brand_id',
        'category_id',
        'price',
        'on_home_page',
        'sorting',
        'text',
        'json_properties',
    ];

    protected $casts = [
        'price'           => PriceCast::class,
        'old_price'       => PriceCast::class,
        'purchase_price'  => PriceCast::class,
        'json_properties' => 'array'
    ];

    protected static function boot() {
        parent::boot();

        static::created( function ( Product $product ) {
            ProductJsonProperties::dispatch( $product )->delay( now()->addSeconds( 10 ) );
        } );
    }

    public function newEloquentBuilder( $query ): ProductQueryBuilder {
        return new ProductQueryBuilder( $query );
    }


    public function brand(): BelongsTo {
        return $this->belongsTo( Brand::class );
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany( Category::class );
    }

    public function properties() {
        return $this->belongsToMany( Property::class )
                    ->withPivot( 'value' );
    }

    public function optionValues(): BelongsToMany {
        return $this->belongsToMany( OptionValue::class );
    }

    protected function thumbnailDir(): string {
        return 'products';
    }
}
