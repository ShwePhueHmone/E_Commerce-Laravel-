<?php

namespace App\Models;

use App\Contracts\Likeable;
use App\Models\Concerns\Likes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements Likeable
{
    use HasFactory, SoftDeletes, Likes;

    public $fillable = ['user_id', 'name', 'description', 'sizes', 'colors', 'price', 'image'];

    /**
     * Get the user that owns the product.
     */
    public function user()
    {

        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function categories()
    {

        return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
    }

    /**
     * Get the order that owns the product.
     */
    public function orders()
    {

        return $this->belongsToMany(Order::class, 'orders_products', 'product_id', 'order_id');
    }

    /**
     * Search posts by name.
     */
    public function scopeFilter($query, $search)
    {

        return $query->when($search ?? false, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    /**
     * Get all of the product's image.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

}