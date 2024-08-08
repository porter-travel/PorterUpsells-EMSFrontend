<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Product;
use App\Models\ProductSpecific;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function show($hotel_id, $item_id, Request $request)
    {

//        var_dump($request->session()->all());

        if (is_numeric($hotel_id)) {
            $hotel = Hotel::find($hotel_id);
        } else {
            $hotel = Hotel::where('slug', $hotel_id)->first();
        }


        $product = Product::find($item_id);
        $variations = $product->variations;
        $specifics = $product->specifics->mapWithKeys(function ($specific) {
            return [$specific->name => (bool)$specific->value];
        })->toArray();

//        dd($specifics);

        $have_details = true;

        if(isset($specifics['on_arrival']) && $specifics['on_arrival'] && !$request->session()->get('arrival_date')){
            $have_details = false;
        }

        if(isset($specifics['on_departure']) && $specifics['on_departure'] && !$request->session()->get('departure_date')){
            $have_details = false;
        }

        $cart = session()->get('cart');

        $cartCount = 0;
        if ($cart) {
            foreach ($cart as $item) {
                if (is_array($item)) {
                    $cartCount++;
                }
            }
        }

        $arrivalDate = $request->session()->get('arrival_date');
        $departureDate = $request->session()->get('departure_date');

        $dateArray = $this->getDatesInRange($arrivalDate, $departureDate, $specifics);

        return view('hotel.item', [
            'hotel_id' => $hotel_id,
            'item_id' => $item_id,
            'hotel' => $hotel,
            'product' => $product,
            'variations' => $variations,
            'cart' => $cart,
            'cartCount' => $cartCount,
            'dateArray' => $dateArray,
            'specifics' => $specifics,
            'have_details' => $have_details
        ]);
    }

    public function create($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        return view('admin.product.create', ['hotel' => $hotel]);
    }

    public function edit($hotel_id, $product_id)
    {
        $hotel = Hotel::find($hotel_id);
        $product = Product::with('specifics')->find($product_id);
        $specificsArray = $product->specifics->mapWithKeys(function ($specific) {
            return [$specific->name => (bool) $specific->value];
        })->toArray();

        $product->specifics = $specificsArray;

//        dd($product);
        return view('admin.product.edit', ['hotel' => $hotel, 'product' => $product]);
    }


    public function store(Request $request)
    {

        $filePath = $request->file('image')->store('product-images', 's3');

        // You can also specify visibility and ACL (Access Control List) if needed
        // $filePath = $request->file('logo')->store('path/to/your/s3/folder', 's3', 'public');

        // If you need to generate a URL to the uploaded file
        $url = Storage::disk('s3')->url($filePath);


        $product = new Product();
        $product->status = $request->status;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->hotel_id = $request->hotel_id;
        $product->image = $url;
        $product->save();

        if (isset($request->variants)) {
            foreach ($request->variants as $variant) {

                if ($variant['variant_image']) {
                    $filePath = $variant['variant_image']->store('product-images', 's3');
                    $url = Storage::disk('s3')->url($filePath);
                }

                $product->variations()->create([
                    'name' => $variant['variant_name'],
                    'price' => $variant['variant_price'],
                    'image' => $url
                ]);
            }
        } else {
            $product->variations()->create([
                'name' => $request->name,
                'price' => $request->price,
                'image' => $url
            ]);
        }

        if(isset($request->specifics)){
            foreach($request->specifics as $name => $specific){
                $product->specifics()->create([
                    'name' => $name,
                    'value' => $specific
                ]);
            }
        }

        return redirect()->route('hotel.edit', ['id' => $request->hotel_id]);
    }

    public function update(Request $request)
    {


        $product = Product::find($request->product_id);

        if ($request->status) {
            $product->status = $request->status;
        }

        if ($request->name) {
            $product->name = $request->name;
        }

        if ($request->description) {
            $product->description = $request->description;
        }

        if ($request->price) {
            $product->price = $request->price;
        }

        if ($request->file('image')) {
            $filePath = $request->file('image')->store('product-images', 's3');
            $url = Storage::disk('s3')->url($filePath);
            $product->image = $url;
        }

        $product->save();

        if (isset($request->variants)) {
            foreach ($request->variants as $variant) {
                if (isset($variant['variant_id'])) {
                    $variation = $product->variations()->find($variant['variant_id']);
                    $variation->name = $variant['variant_name'];
                    $variation->price = $variant['variant_price'];
                    if (isset($variant['variant_image'])) {
                        $filePath = $variant['variant_image']->store('product-images', 's3');
                        $url = Storage::disk('s3')->url($filePath);
                    } else {
                        $url = $product->image;
                    }
                    $variation->image = $url;
                    $variation->save();
                } else {
                    if (isset($variant['variant_image'])) {
                        $filePath = $variant['variant_image']->store('product-images', 's3');
                        $url = Storage::disk('s3')->url($filePath);
                    } else {
                        $url = $product->image;
                    }
                    $product->variations()->create([
                        'name' => $variant['variant_name'],
                        'price' => $variant['variant_price'],
                        'image' => $url
                    ]);
                }
            }
        }

        if (isset($request->remove)) {
            foreach ($request->remove as $remove) {
                $variation = $product->variations()->find($remove);
                $variation->delete();
            }
        }

        if($product->variations->count() == 0){
            $product->variations()->create([
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image
            ]);
        }

        if($product->variations->count() == 1){
            $variation = $product->variations->first();
            $variation->name = $product->name;
            $variation->price = $product->price;
            $variation->image = $product->image;
            $variation->save();
        }
//dd($request->specifics);
        if(isset($request->specifics)){
            foreach($request->specifics as $name => $specific){
                $ps = ProductSpecific::where('product_id', $product->id)->where('name', $name)->first();
                if($ps){
                    $ps->value = $specific;
                    $ps->save();
                } else {
                    $product->specifics()->create([
                        'name' => $name,
                        'value' => $specific
                    ]);
                }
            }
        }

        return redirect()->route('product.edit', ['hotel_id' => $request->hotel_id, 'product_id' => $request->product_id]);

    }

    private function getDatesInRange($arrivalDate, $departureDate, $specifics){

        if(isset($specifics['on_departure']) && !$specifics['on_departure'] && isset($specifics['during_stay']) &&  !$specifics['during_stay']){
            return [$arrivalDate];
        }

        if(isset($specifics['on_arrival']) && !$specifics['on_arrival'] && isset($specifics['during_stay']) && !$specifics['during_stay']){
            return [$departureDate];
        }

        if(isset($specifics['during_stay']) && !$specifics['during_stay']){
            return [$arrivalDate, $departureDate];
        }

        $start = new \DateTime($arrivalDate);
        $end = new \DateTime($departureDate);

        if(isset($specifics['on_arrival']) && !$specifics['on_arrival']){
            $start->modify('+1 day');
        }

        if(isset($specifics['on_departure']) && $specifics['on_departure']){
            $end->modify('+1 day'); // Include the end date in the period
        }

        $dates = [];
        $interval = new \DateInterval('P1D'); // 1 day interval
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }
}
