<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Variation;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function show($hotel_id)
    {

        session()->put('hotel_id', $hotel_id);


        $this->removeFromCartIfProductFromWrongHotel();


        $data['cart'] = session()->get('cart');
        if (is_numeric($hotel_id)) {
            $hotel = Hotel::find($hotel_id);
        } else {
            $hotel = Hotel::where('slug', $hotel_id)->first();
        }
        return view('cart.show', ['data' => $data, 'hotel' => $hotel])->with('hotel_id', $hotel_id);
    }

    function addToCart(Request $request)
    {
        $items = $request->all()['formObj'];
//dd($items);
        $id = $items['variation_id'];
        $quantity = $items['quantity'];
        $product_id = $items['product_id'];
        $hotel_id = $items['hotel_id'];
        $product_name = $items['product_name'];
        $product_type = $items['product_type'];

        if (!is_array($items['dates[]'])) {
            $dates = array($items['dates[]']);
        } else {
            $dates = $items['dates[]'];
        }

        $product = Variation::find($id);

        if (!$product) {

            abort(404);
        }

        $cart = session()->get('cart');
        if (!$cart) {

            $cart = [];
            foreach ($dates as $date) {
                $cart[$date . '-' . $id] = [
                    'product_id' => $product_id,
                    'variation_id' => $id,
                    'hotel_id' => $hotel_id,
                    'product_name' => $product_name,
                    "variation_name" => $product->name,
                    "quantity" => $quantity,
                    "price" => $product->price,
                    "image" => $product->image,
                    "date" => $date,
                    "product_type" => $product_type
                ];
            }
            $cart = $this->calculateCartTotals($cart);
            session()->put('cart', $cart);

            return json_encode(['message' => 'Product added to cart successfully!', 'cart' => $cart]);
        }

//        dd($cart);
        foreach ($dates as $date) {
            if (isset($cart[$date . '-' . $id])) {
                $cart[$date . '-' . $id]['quantity'] += $quantity;
                $cart = $this->calculateCartTotals($cart);
                session()->put('cart', $cart);
                return json_encode(['message' => 'Product added to cart successfully!', 'cart' => $cart]);
            }
        }

        foreach ($dates as $date) {
            $cart[$date . '-' . $id] = [
                'product_id' => $product_id,
                'variation_id' => $id,
                'hotel_id' => $hotel_id,
                'product_name' => $product_name,
                "variation_name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image,
                "date" => $date,
                "product_type" => $product_type

            ];
        }
        $cart = $this->calculateCartTotals($cart);

        $cartCount = 0;
        foreach ($cart as $item) {
            if (is_array($item)) {
                $cartCount++;
            }
        }
        session()->put('cart', $cart);

        return json_encode(['message' => 'Product added to cart successfully!', 'cart' => $cart]);
    }


    function removeFromCart($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {

            unset($cart[$id]);
            $cart = $this->calculateCartTotals($cart);
            session()->put('cart', $cart);
        }

        return json_encode(['success' => 'Cart updated successfully', $cart]);
    }

    function removeFromCartIfProductFromWrongHotel()
    {
        $cart = session()->get('cart');
        $hotel_id = session()->get('hotel_id');

        if (is_numeric($hotel_id)) {
            $hotel = Hotel::find($hotel_id);
            $hotel_id = $hotel->slug;
        }

        if(is_array($cart)) {
            foreach ($cart as $key => $item) {
                if (is_array($item) && $item['hotel_id'] != $hotel_id) {
                    unset($cart[$key]);
                }
            }
        }

        $cart = $this->calculateCartTotals($cart);

        session()->put('cart', $cart);
    }

    function updateCartQty(Request $request, $id)
    {


        $cart = session()->get('cart');

        if ($request->quantity) {
            $cart[$id]['quantity'] = $request->quantity;
            $cart = $this->calculateCartTotals($cart);
            session()->put('cart', $cart);
            return json_encode(['success' => 'Cart updated successfully', $cart]);
        }
    }

    private function calculateCartTotals($cart)
    {
        $cart['total'] = $this->calculateTotal($cart);
        $cart['total_with_tax'] = $this->calculateTotalWithTax($cart);
        $cart['tax'] = $this->calculateTax($cart);
        $cartCount = 0;
        foreach ($cart as $item) {
            if (is_array($item)) {
                $cartCount += $item['quantity'];
            }
        }
        $cart['cartCount'] = $cartCount;
        return $cart;
    }


    private function calculateTotal($cart)
    {
        $total = 0;
        if(is_array($cart)) {
            foreach ($cart as $item) {
                if (is_array($item))
                    $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }

    private function calculateTotalWithTax($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            if (is_array($item))
                $total += $item['price'] * $item['quantity'];
        }
        return $total * 1.2;
    }

    private function calculateTax($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            if (is_array($item))
                $total += $item['price'] * $item['quantity'];
        }
        return $total * 0.2;
    }
}
