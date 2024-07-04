<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerEmail extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'email_type', 'scheduled_at', 'sent_at'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
