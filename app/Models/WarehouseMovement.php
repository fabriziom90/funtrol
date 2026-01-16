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

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function recepy(){
        return $this->belongsTo(Recepy::class, 'recepy_id');
    }
}
