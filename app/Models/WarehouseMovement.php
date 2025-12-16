<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'quantity',
        'before_quantity',
        'after_quantity',
        'product_id',
        'recepy_id',
        'date',
        'note',
        'user_id',
    ];
}
