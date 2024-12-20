<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarBooking extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variation()
    {
        return $this->hasOne(Variation::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
