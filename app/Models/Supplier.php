<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToStore;

class Supplier extends Model
{
    use HasFactory;
    use BelongsToStore;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }
}
