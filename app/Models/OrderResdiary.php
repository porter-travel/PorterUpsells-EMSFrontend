<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderResdiary extends Model
{
    use HasFactory;

    protected $table = 'orders_resdiary';

    protected $fillable = [
        'hotel_id',
        'order_id',
        'resdiary_id',
        'resdiary_status',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_mobile',
        'visit_date',
        'visit_time',
        'party_size',
        'special_requests',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
