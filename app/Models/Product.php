<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
    protected $fillable = ['name', 'description', 'price', 'image', 'stock', 'category_id'];
public function category()
{
    return $this->belongsTo(Category::class);
}
public function isNew()
{
    return $this->created_at >= now()->subDays(7); // New if added in the last 7 days
}
}
