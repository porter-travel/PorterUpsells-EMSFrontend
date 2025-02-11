<?php

namespace App\Http\Controllers;

use App\Helpers\Intervals;
use App\Jobs\TrackProductView;
use App\Models\CalendarBooking;
use App\Models\Hotel;
use App\Models\Product;
use App\Models\ProductSpecific;
use App\Models\Unavailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function show($hotel_id, $item_id, Request $request)
    {



        if (is_numeric($hotel_id)) {
            $hotel = Hotel::find($hotel_id);
        } else {
            $hotel = Hotel::where('slug', $hotel_id)->first();
        }

        TrackProductView::dispatch($hotel->id, $item_id);


        $product = Product::find($item_id);
        $variations = $product->variations;
        $specifics = $product->specifics->mapWithKeys(function ($specific) {
            return [$specific->name => $this->parseSpecificsValue($specific->value)];
        })->toArray();


        $have_details = true;

        if (!isset($specifics['on_arrival'])) {
            $specifics['on_arrival'] = true;
        }

        if (isset($specifics['on_arrival']) && $specifics['on_arrival'] && !$request->session()->get('arrival_date')) {
            $have_details = false;
        }

        if (isset($specifics['on_departure']) && $specifics['on_departure'] && !$request->session()->get('departure_date')) {
            $have_details = false;
        }

        if (isset($specifics['during_stay']) && $specifics['during_stay'] && !$request->session()->get('arrival_date') && !$request->session()->get('departure_date')) {
            $have_details = false;
        }


        if (isset($specifics['on_departure']) && $specifics['on_departure'] && isset($specifics['on_arrival']) && $specifics['on_arrival']) {
            $date_picker_title = 'To add this product, first let us know the dates of your stay';
        } elseif (isset($specifics['during_stay']) && $specifics['during_stay']) {
            $date_picker_title = 'To add this product, let us know the dates of your stay';
        } elseif (isset($specifics['on_arrival']) && $specifics['on_arrival']) {
            $date_picker_title = 'To add this product, let us know the date of your arrival';
        } elseif (isset($specifics['on_departure']) && $specifics['on_departure']) {
//            dd('here');
            $date_picker_title = 'To add this product, let us know the date of your departure';
        } else {
            $date_picker_title = 'To add this product, let us know the dates of your stay';
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

        $unavailabilities = Unavailability::where('product_id', $item_id)->get();

        $dateArray = $this->getDatesInRange($arrivalDate, $departureDate, $specifics, $unavailabilities);

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
            'have_details' => $have_details,
            'date_picker_title' => $date_picker_title,
            'type' => $product->type
        ]);
    }

    public function create($hotel_id, $type = null)
    {
        $hotel = Hotel::find($hotel_id);

        if ($type == null) {
            $type = 'standard';
        }
        return view('admin.product.create', ['hotel' => $hotel, 'type' => $type]);
    }

    public function edit($hotel_id, $product_id)
    {
        $hotel = Hotel::find($hotel_id);
        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return redirect()->route('dashboard');
        }
        $product = Product::with(['specifics', 'unavailabilities'])->find($product_id);
        $specificsArray = $product->specifics->mapWithKeys(function ($specific) {
            return [$specific->name => $this->parseSpecificsValue($specific->value)];
        })->toArray();

        $product->specifics = $specificsArray;


        return view('admin.product.edit', ['hotel' => $hotel, 'product' => $product, 'type' => $product->type]);
    }

    private function parseSpecificsValue($value)
    {
        if ($value == '1' || $value == '0' || $value == 1 || $value == 0) {
            return (bool)$value;
        } else {
            return $value;
        }
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
        $product->description = strip_tags($request->description, '<p><a><strong><em><ul><li><ol><br>');
        $product->price = $request->price;
        $product->hotel_id = $request->hotel_id;
        $product->image = $url;
        $product->type = $request->type;
        $product->save();


//        dd($request->variants);
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


//        dd($request->specifics);

        if (isset($request->specifics)) {
            foreach ($request->specifics as $name => $specific) {
                if ($specific != null) {
                    $product->specifics()->create([
                        'name' => $name,
                        'value' => $specific
                    ]);
                }
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

//dd($request->variants);
        if (isset($request->variants)) {
            foreach ($request->variants as $variant) {
                if (isset($variant['variant_id'])) {
                    $variation = $product->variations()->find($variant['variant_id']);
//                    dd($variation);
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

        if ($product->variations->count() == 0) {
            $product->variations()->create([
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image
            ]);
        }

        if ($product->variations->count() == 1) {
            $variation = $product->variations->first();
            $variation->name = $product->name;
            $variation->price = $product->price;
            $variation->image = $product->image;
            $variation->save();
        }
//dd($request->specifics);
        if (isset($request->specifics)) {
            foreach ($request->specifics as $name => $specific) {
                $ps = ProductSpecific::where('product_id', $product->id)->where('name', $name)->first();
                if ($ps) {
                    $ps->value = $specific ?: 0;
                    $ps->save();
                } else {
                    $product->specifics()->create([
                        'name' => $name,
                        'value' => $specific ?: 0
                    ]);
                }
            }
        }

        return redirect()->route('product.edit', ['hotel_id' => $request->hotel_id, 'product_id' => $request->product_id]);

    }


    public function listProductsAsJson($hotel_id)
    {
        $products = Product::where('hotel_id', $hotel_id)->get();
        return response()->json($products);
    }

    public function getProductAsJson($product_id)
    {
        $product = Product::find($product_id);
        return response()->json($product);
    }

    public function getTimesAvailableForCalendarProducts(Request $request)
    {
        $product_id = $request->product_id;
        $day = strtolower($request->day);
        $date = $request->date;
        $product = Product::find($product_id);
        $concurrentAvailability = $product->specifics->where('name', "concurrent_availability")->first()->value;

        $existingBookings = CalendarBooking::where('product_id', $product_id)->where('date', $date)->get();


        $product = Product::find($product_id);
        $interval = $product->specifics->where('name', "time_intervals")->first()->value;
        $startTime = $product->specifics->where('name', "start_time_{$day}")->first()->value;
        $endTime = $product->specifics->where('name', "end_time_{$day}")->first()->value;

        $start = strtotime($startTime);
        $end = strtotime($endTime);
        $availableTimes = [];

        $step = Intervals::wordsToMinutes($interval);

        // Generate times
        for ($time = $start; $time + $step <= $end; $time += $step) {
            $availableTimes[] = ['qty' => (int)$concurrentAvailability, 'time' => date('H:i', $time)];
        }

        $bookings = [];
        if (count($existingBookings) > 0) {
            foreach ($existingBookings as $booking) {
//                dd($booking->start_time);
                $bookings[] = date('H:i', strtotime($booking->start_time));
            }
        }

        foreach ($bookings as $booking){
//            dd($booking);
            foreach ($availableTimes as $key => $time){
                if ($time['time'] == $booking){
                    $availableTimes[$key]['qty'] = $availableTimes[$key]['qty'] - 1;
                }
            }
        }

        foreach ($availableTimes as $key => $time){
            if ($time['qty'] == 0){
                unset($availableTimes[$key]);
            }
        }
        //Reset the keys on the $availableTimes Array
        $availableTimes = array_values($availableTimes);

        return response($availableTimes);

    }

    public function softDeleteProduct($hotel_id, $product_id)
    {

        $hotel = Hotel::find($hotel_id);
        if ($hotel->user_id != auth()->user()->id && auth()->user()->role != 'superadmin') {
            return redirect()->route('dashboard');
        }


        $product = Product::find($product_id);
        $product->deleted_at = now();
        $product->save();
        return redirect()->route('hotel.edit', ['id' => $product->hotel_id]);
    }

    private function getDatesInRange($arrivalDate, $departureDate, $specifics, $unavailabilities)
    {
//var_dump($specifics);
//echo '<br>';
//var_dump($departureDate);
        if (!isset($specifics['on_arrival']) && !isset($specifics['on_departure']) && !isset($specifics['during_stay'])) {
            return [['date' => $arrivalDate, 'status' => 'available']];
        }

        if (isset($specifics['notice_period']) && $specifics['notice_period'] > 0) {
            $noticePeriod = $specifics['notice_period'];
//Notice period is a number so  calculate the date that is $noticePeriod days from today
            $today = new \DateTime();
            $today->modify('+' . $noticePeriod . ' day');
            $noticeDay = $today->format('Y-m-d');
//            var_dump($noticeDay);
        } else {
            $noticeDay = null;
        }

        if ($departureDate && ($noticeDay > $departureDate)) {
            return ['error' => 'You must book this product at least ' . $noticePeriod . ' days before your stay'];
        }

//        dd($specifics, count($specifics) == 1, isset($specifics['on_arrival']), $specifics['on_arrival'], $arrivalDate);

        if (count($specifics) == 1 && isset($specifics['on_arrival']) && $specifics['on_arrival']) {
            if ($noticeDay && $noticeDay > $arrivalDate) {
                return ['error' => 'You must book this product at least ' . $noticePeriod . ' days before your arrival date'];
            }
            return [['date' => $arrivalDate, 'status' => 'available']];
        }

        if (isset($specifics['on_departure']) && !$specifics['on_departure'] && isset($specifics['during_stay']) && !$specifics['during_stay']) {
            if ($noticeDay && $noticeDay > $arrivalDate) {
                return ['error' => 'You must book this product at least ' . $noticePeriod . ' days before your arrival date'];
            }
            return [['date' => $arrivalDate, 'status' => 'available']];
        }

        if (isset($specifics['on_arrival']) && !$specifics['on_arrival'] && isset($specifics['during_stay']) && !$specifics['during_stay']) {
            if ($noticeDay && $noticeDay > $arrivalDate) {
                return ['error' => 'You must book this product at least ' . $noticePeriod . ' days before your departure date'];
            }
            return [['date' => $departureDate, 'status' => 'available']];
        }

//        if (isset($specifics['during_stay']) && !$specifics['during_stay']) {
//            if ($noticeDay && $noticeDay > $arrivalDate) {
//                return ['error' => 'You must book this product at least ' . $noticePeriod . ' days before your departure date'];
//            }
//            return [['date' => $arrivalDate, 'status' => 'available'],['date' =>  $departureDate, 'status' => 'available']];
//        }


//        dd($unavailabilities->toArray());

        $unavailable_ranges = array_map(function ($range) {
            return [
                'from' => new \DateTime($range['start_at']),
                'to' => new \DateTime($range['end_at']),
                'is_recurrent' => $range['is_recurrent']
            ];
        }, $unavailabilities->toArray());

        $start = new \DateTime($arrivalDate);
        $end = new \DateTime($departureDate);


        $dates = [];
        $interval = new \DateInterval('P1D'); // 1 day interval
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $key => $date) {
            $status = 'available';
            $status = $this->checkDayOfWeek($date, $specifics);

            foreach ($unavailable_ranges as $range) {
                if ($range['is_recurrent']) {
                    // Compare month and day only, ignoring the year
                    $date_month_day = $date->format('m-d');
                    $from_month_day = $range['from']->format('m-d');
                    $to_month_day = $range['to']->format('m-d');

                    if ($date_month_day >= $from_month_day && $date_month_day <= $to_month_day) {
                        $status = 'unavailable';
                        break; // No need to check further if already unavailable
                    }
                } else {
                    // Normal date comparison including the year
                    if ($date >= $range['from'] && $date <= $range['to']) {
                        $status = 'unavailable';
                        break; // No need to check further if already unavailable
                    }
                }
            }


            if (isset($specifics['on_departure']) && !$specifics['on_departure'] && $key == count((array)$period) - 1) {
                $status = 'unavailable';
            }
            if (isset($specifics['on_arrival']) && !$specifics['on_arrival'] && $key == 0) {
                $status = 'unavailable';
            }

            if (isset($specifics['during_stay']) && !$specifics['during_stay'] && $key != 0 && $key != count((array)$period) - 1) {
                $status = 'unavailable';
            }

            if ($noticeDay) {
                if ($date->format('Y-m-d') >= $noticeDay) {
                    $status = 'available';
                } else {
                    $status = 'unavailable';
                }
            }
            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'status' => $status
            ];

        }

        return $dates;
    }

    function checkDayOfWeek($date, $specifics)
    {
        // Check if any day keys are present in the specifics array
        $days = [
            'available_monday',
            'available_tuesday',
            'available_wednesday',
            'available_thursday',
            'available_friday',
            'available_saturday',
            'available_sunday'
        ];

        // Extract the day of the week from the $date
        $dayOfWeek = strtolower($date->format('l')); // 'Monday', 'Tuesday', etc.
        $specificDayKey = "available_{$dayOfWeek}"; // Construct the key, e.g., 'available_monday'

        // Check if the specifics array has any of the day keys set
        $hasDaysSet = array_intersect_key(array_flip($days), $specifics);

        // If no days are mentioned in specifics, return 'available' by default
        if (empty($hasDaysSet)) {
            return 'available';
        }

        // Return the status based on the specific day availability
        return $specifics[$specificDayKey] ?? false ? 'available' : 'unavailable';
    }
}
