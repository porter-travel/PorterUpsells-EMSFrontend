<?php

namespace App\Models;

use App\Mail\OrderConfirmation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'items',
        'name',
        'email',
        'arrival_date',
        'stripe_id',
        'payment_status',
        'subtotal',
        'total_tax',
        'total'
    ];

    public function fromSessionData($data){
        return $this->create([
            'hotel_id' => $data['hotel_id'],
            'items' => json_encode($data['items']),
            'name' => $data['name'],
            'email' => $data['email'],
            'arrival_date' => $data['arrival_date'],
            'subtotal' => $data['subtotal'],
            'total_tax' => $data['total_tax'],
            'total' => $data['total']
        ]);
    }

    public function fromStripeResponse($response){


        $order = $this->create([
            'hotel_id' => $response->metadata->hotel_id,
            'items' => json_encode($response->line_items->data),
            'name' => $response->metadata->name,
            'email' => $response->customer_details->email,
            'arrival_date' => $response->metadata->arrival_date,
            'stripe_id' => $response->id,
            'payment_status' => $response->payment_status,
            'subtotal' => $response->amount_subtotal,
            'total_tax' => $response->total_details->amount_tax,
            'total' => $response->amount_total
        ]);

        Mail::to($order->email)->send(new OrderConfirmation($order));

        return $order;

    }


}
