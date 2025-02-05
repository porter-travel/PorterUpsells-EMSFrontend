<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAnalytics extends Model
{
    use HasFactory;

    protected $table = 'cart_analytics';

    protected $fillable = ['hotel_id', 'view_date', 'product_id', 'variation_id', 'added_to_cart_count'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }


}
