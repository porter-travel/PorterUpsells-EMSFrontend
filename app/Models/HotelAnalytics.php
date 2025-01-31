<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAnalytics extends Model
{
    use HasFactory;

    protected $table = 'hotel_analytics';

    protected $fillable = ['hotel_id', 'view_date', 'dashboard_views'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
