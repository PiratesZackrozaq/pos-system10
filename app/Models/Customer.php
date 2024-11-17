<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // A customer belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Specify foreign key as 'user_id'
    }

    // If primary key is not 'id', specify it
    protected $primaryKey = 'customer_id'; // Or whatever your primary key is
    // Disable 'updated_at' but still manage 'created_at'
    const UPDATED_AT = null;

    protected $fillable = [
        'name', 'email', 'phone', 'status', 'user_id'
    ];
}
