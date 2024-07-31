<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FulfilmentKey extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'hotel_id', 'expires_at', 'user_id'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
