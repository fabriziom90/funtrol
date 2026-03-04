<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToStore;

class Product extends Model
{
    use HasFactory;
    use BelongsToStore;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // relazione con le ricette (many-to-many)
    public function recepies()
    {
        return $this->belongsToMany(Recepy::class, 'product_recepy')
            ->withPivot('grams_used');
    }

    public function warehouseMovements(){
        return $this->hasMany(WarehouseMovement::class);
    }

    public function productOrdereds()
    {
        return $this->hasMany(ProductOrdered::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_ordereds')
            ->withPivot(['quantity', 'unit_price'])
            ->withTimestamps();
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
