<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'name',
        'email',
        'mobile',
        'room_number',
        'date',
        'start_time',
        'end_time',
        'status',
        'hotel_id',
        'qty',
        'slot',
    ];

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

    public function childBookings(){
        return CalendarBooking::where('parent_booking_id', $this->id)->get();
    }
}
