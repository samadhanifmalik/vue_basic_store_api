<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'minimum_qty',
        'stock_qty',
        'photo'
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
