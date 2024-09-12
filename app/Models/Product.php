<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function specifics()
    {
        return $this->hasMany(ProductSpecific::class);
    }

    public function unavailabilities()
    {
        return $this->hasMany(Unavailability::class);
    }


}
