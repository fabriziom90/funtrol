<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_name',
        'email',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function recepies(){
        return $this->hasMany(Recepy::class);
    }

    public function suppliers(){
        return $this->hasMany(Store::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
