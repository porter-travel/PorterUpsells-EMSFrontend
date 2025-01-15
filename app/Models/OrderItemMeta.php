<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemMeta extends Model
{
    use HasFactory;

    protected $table = 'order_items_meta';

    protected $fillable = ['order_item_id', 'key', 'value'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
