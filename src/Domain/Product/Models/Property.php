<?php

namespace Domain\Product\Models;

use Domain\Product\Collections\PropertiesCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model {
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function newCollection( array $models = [] ) {
        return new PropertiesCollection( $models );
    }
}
