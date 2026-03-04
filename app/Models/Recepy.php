<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToStore;

class Recepy extends Model
{
    use HasFactory;
    use BelongsToStore;

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('grams_used');
    }

    public function warehouseMovements(){
        return $this->hasMany(warehouseMovement::class);
    }
}
