<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // A customer belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Specify foreign key as 'user_id'
    }

    // If primary key is not 'id', specify it
    protected $primaryKey = 'order_items_id'; // Or whatever your primary key is
}
