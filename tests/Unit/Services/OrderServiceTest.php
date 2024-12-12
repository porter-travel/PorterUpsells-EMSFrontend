<?php

namespace Tests\Unit\Services;

use App\Models\Hotel;
use App\Models\Order;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Mockery;

class OrderServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetOrdersByHotelForNextSevenDays()
    {
        // Mock dependencies
        $hotelMock = Mockery::mock(Hotel::class);
        $hotelMock->shouldReceive('find')->with(1)->andReturn($hotelMock);

        $orderMock = Mockery::mock(Order::class);
        $orderQueryMock = Mockery::mock('Illuminate\Database\Eloquent\Builder');
        $itemQueryMock = Mockery::mock('Illuminate\Database\Eloquent\Builder');

        $itemQueryMock->shouldReceive('whereDate')
            ->with('date', '>=', Carbon::now()->startOfDay()->toDateString())
            ->andReturnSelf();
        $itemQueryMock->shouldReceive('whereDate')
            ->with('date', '<=', Carbon::now()->addDays(7)->endOfDay()->toDateString())
            ->andReturnSelf();

        $orderQueryMock->shouldReceive('where')
            ->with('hotel_id', 1)
            ->andReturnSelf();
        $orderQueryMock->shouldReceive('where')
            ->with('payment_status', '!=', 'pending')
            ->andReturnSelf();
        $orderQueryMock->shouldReceive('whereHas')
            ->with('items', Mockery::on(function ($closure) use ($itemQueryMock) {
                $closure($itemQueryMock);
                return true;
            }))
            ->andReturnSelf();
        $orderQueryMock->shouldReceive('with')
            ->with(['items' => Mockery::type('Closure'), 'items.product', 'items.product.specifics', 'booking', 'items.meta'])
            ->andReturnSelf();
        $orderQueryMock->shouldReceive('get')->andReturn(collect([]));

        $orderMock->shouldReceive('newQuery')->andReturn($orderQueryMock);

        // Replace the actual models with mocks
        $this->app->instance(Hotel::class, $hotelMock);
        $this->app->instance(Order::class, $orderMock);

        // Test the service
        $service = new OrderService();
        $result = $service->getOrdersByHotelForNextSevenDays(1);

        $this->assertIsArray($result);
        $this->assertCount(0, $result, 'Expected no orders as mock returns an empty collection.');
    }






}
