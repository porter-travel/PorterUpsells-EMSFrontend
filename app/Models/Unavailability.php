<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unavailability extends Model
{
    use HasFactory;

    protected $fillable = ['start_at', 'end_at', 'is_recurrent'];

    protected  $table = 'unavailabilities';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
