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

    public function unsentCustomerEmails()
    {
        return $this->customerEmails()->whereNull('sent_at')->get();
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
