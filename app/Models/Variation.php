<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'image', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calendarBookings()
    {
        return $this->belongsToMany(CalendarBooking::class);

    }
}
