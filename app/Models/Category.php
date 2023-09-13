<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'name',
        'parent_id',
        'description',
        'photo',
    ];
    public function children()
    {
	return $this->belongsTo(Category::class, 'parent_id');
    }
    public function products()
    {
        return $this->belongsToMany(Products::class);
    }
}
