<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'categories_id',
        'description',
        'photo_product',
        'price',
        'quantity',
        'status',

    ];

    public function categories () {
        return $this->belongsTo(Categories::class);
    }
}
