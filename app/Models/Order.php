<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 
        'tracking_no', 
        'invoice_no', 
        'total_amount', 
        'order_date', 
        'order_status', 
        'payment_mode', 
        'order_placed_by_id',
    ];
    
    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // A customer belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Specify foreign key as 'user_id'
    }

    // If primary key is not 'id', specify it
    protected $primaryKey = 'order_id'; // Or whatever your primary key is
}
