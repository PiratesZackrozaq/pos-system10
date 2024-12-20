<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Relationships
    public function categories()
    {
        return $this->hasMany(Category::class, 'user_id'); // Ensure the foreign key
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id');  // Specify foreign key as 'user_id'
    }

    public function orders()
    {
        return $this->hasMany(Customer::class, 'user_id');  // Specify foreign key as 'user_id'
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id'); // Specify foreign key as 'user_id'
    }

    // Specify the primary key column
    protected $primaryKey = 'user_id';

    // If your 'user_id' is not auto-incrementing, set this to false
    public $incrementing = true;

    // If 'user_id' is not an integer type
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
