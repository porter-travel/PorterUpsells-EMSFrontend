<?php
namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Services\PerformanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    protected $performanceService;

    public function __construct(PerformanceService $performanceService)
    {
        $this->performanceService = $performanceService;
    }

    public function index(Request $request, $hotel_id = null)
    {
        $user = auth()->user();

        // Handle date range
        [$startDate, $endDate] = $this->getDateRange($request);

        // Fetch hotels
        $hotels = $this->getHotels($user);
        $hotelIds = $hotels->pluck('id')->toArray();

        $hotel = $hotel_id ? $hotels->where('id', $hotel_id)->first() : null;

        if ($hotel_id && !$hotel) {
            return redirect()->route('admin.performance.index');
        }

        // Get analytics data
        $analytics = $this->performanceService->getAnalytics(
            $hotel_id ? [$hotel_id] : $hotelIds,
            $startDate,
            $endDate
        );

//        dd($analytics['customerAnalytics']->sortByDesc('total_value'));
//        dd($analytics['productAnalytics']);
        // Return view
        return view('admin.performance.index', [
            'productViews' => $analytics['productViews'],
            'totalProductViews' => $analytics['productViews']->sum(),
            'totalDashboardViews' => $analytics['hotelAnalytics']->sum('dashboard_views'),
            'totalCartViews' => $analytics['hotelAnalytics']->sum('cart_views'),
            'hotelAnalytics' => $analytics['hotelAnalytics'],
            'totalAddsToCart' => $analytics['cartAnalytics']->sum('added_to_cart_count'),
            'emailCount' => $analytics['emailCount'],
            'cartAnalytics' => $analytics['cartAnalytics'],
            'totalOrders' => $analytics['orders']->count(),
            'totalSales' => $analytics['orders']->sum('subtotal'),
            'hotelOrders' => $analytics['hotelOrders'],
            'productAnalytics' => $analytics['productAnalytics'],
            'customerAnalytics' => $analytics['customerAnalytics']->sortByDesc('total_value'),
            'hotels' => $hotels,
            'hotel' => $hotel,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }

    private function getDateRange(Request $request)
    {
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        if ($request->has(['start_date', 'end_date'])) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();
            } catch (\Exception $e) {
                redirect()->back()->withErrors(['Invalid date format provided.']);
            }
        }

        return [$startDate, $endDate];
    }

    private function getHotels($user)
    {
        return $user->role === 'superadmin' ? Hotel::all() : Hotel::whereBelongsTo($user)->get();
    }
}
