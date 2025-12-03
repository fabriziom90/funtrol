<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // relazione con le ricette (many-to-many)
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)->withPivot('quantity'); // quantity opzionale
    }
}
