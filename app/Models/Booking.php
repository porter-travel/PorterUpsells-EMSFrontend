<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['hotel_id', 'name', 'email_address', 'arrival_date', 'departure_date', 'booking_ref'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function customerEmails()
    {
        return $this->hasMany(CustomerEmail::class);
    }
}
