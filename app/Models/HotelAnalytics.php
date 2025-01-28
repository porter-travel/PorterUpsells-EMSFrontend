<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAnalytics extends Model
{
    use HasFactory;

    protected $table = 'hotel_analytics';

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
