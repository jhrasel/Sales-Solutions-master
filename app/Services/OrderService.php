<?php


namespace App\Services;


use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function index($data): LengthAwarePaginator
    {
        return $data = Order::with('order_details', 'pricing')
            ->where('shop_id', $data->header('shop-id'))
            ->where('order_status', $data->type)
            ->orderByDesc('updated_at')
            ->paginate(10);
    }
}
