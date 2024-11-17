<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // A customer belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Specify foreign key as 'user_id'
    }

    // If primary key is not 'id', specify it
    protected $primaryKey = 'product_id'; // Or whatever your primary key is

    // Define fillable fields
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'quantity', 'image', 'status'
    ];

    // Specify relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
