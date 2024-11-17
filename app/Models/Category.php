<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Define the relationship to the user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Specify 'user_id'
    }

    // Specify the attributes that are mass assignable
    protected $fillable = ['name', 'description', 'status', 'user_id'];

    // Define the relationship with Product model
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id'); // Reference the correct foreign key
    }

    // If primary key is not 'id', specify it
    protected $primaryKey = 'category_id'; // Or whatever your primary key is

}

