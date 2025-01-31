<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
class Hotel extends Model
{
    use HasFactory;
    use Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'name',
        'address',
        'logo',
        'user_id',
        'slug',
        'featured_image',

    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function fulfilmentKeys()
    {
        return $this->hasMany(FulfilmentKey::class);
    }

    public function activeProducts(){
        return $this->products()->where('status', 'active')->get();
    }

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function resdiaryOrders()
    {
        return $this->hasMany(OrdersResdiary::class);
    }

    public function calendarBookings()
    {
        return $this->hasMany(CalendarBooking::class);

    }
    public function hotelAnalytics()
    {
        return $this->hasMany(HotelAnalytics::class);
    }

    public function productViews()
    {
        return $this->hasMany(ProductViews::class);
    }

    public function meta()
    {
        return $this->hasMany(HotelMeta::class);
    }

    public function hotelEmails()
    {
        return $this->hasMany(HotelEmail::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
