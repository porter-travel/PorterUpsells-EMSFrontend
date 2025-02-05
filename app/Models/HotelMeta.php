<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'key',
        'value',
    ];

    protected $table = 'hotel_meta';

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
