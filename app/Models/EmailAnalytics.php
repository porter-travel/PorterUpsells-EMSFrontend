<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAnalytics extends Model
{
    use HasFactory;

    protected $table = 'email_analytics';

    protected $fillable = ['hotel_id', 'email_count', 'sent_date'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

}
