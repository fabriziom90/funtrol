<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'total',
        'date_order',
    ];

    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    
    public function productOrdereds()
    {
        return $this->hasMany(ProductOrdered::class);
    }

    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ordereds')
            ->withPivot(['quantity', 'unit_price'])
            ->withTimestamps();
    }
}
