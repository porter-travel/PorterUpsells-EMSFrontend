<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::find($request->id);
        $orderItem->status = $request->status;
        $orderItem->save();

        if($orderItem->status == 'fulfilled') {
            // Send email to customer later
            $className = 'bg-mint';
        }

        if($orderItem->status == 'cancelled') {
            // Send email to customer later
            $className = 'bg-red';
        }

        if($orderItem->status == 'pending') {
            $className = 'bg-pink';
        }

        return response()->json(['message' => 'Order item status updated successfully', 'className' => 'p-2 ' . $className]);
    }
}
