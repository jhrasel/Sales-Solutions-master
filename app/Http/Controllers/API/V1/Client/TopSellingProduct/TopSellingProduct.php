<?php

namespace App\Http\Controllers\API\V1\Client\TopSellingProduct;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopSellingProduct extends Controller
{
    public function index()
    {

        try {

            $merchant = auth()->user();
            $shopID = $merchant->shop->shop_id;
            $orderIds = [];
            $orders = Order::with('order_details')->where('order_status', 'delivery')->where('shop_id', $shopID)->get();

            if (!$orders) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Order not Found',
                ], 404);
            }

            foreach ($orders as $order) {
                $orderIds[] = $order->id;
            }
            

            $orderDetails = OrderDetails::select('product_id', 'product_qty')->whereIn('order_id', $orderIds)->get();
            if (!$orderDetails) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Order Details not found',
                ], 404);
            }

            $sumArray = [];
            foreach ($orderDetails as $order) {
                if (!isset($sumArray[$order->product_id])) {
                    $sumArray[$order->product_id] = 0;
                }
                if (isset($sumArray[$order->product_id])) {
                    $sumArray[$order->product_id] += $order->product_qty;
                }
            }

            $sellingProduct = [];

            foreach ($sumArray as $key => $qty) {
                $product = Product::with('main_image')->where('id', $key)->first();
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'msg' =>  'Product not Found',
                    ], 404);
                }

                $sellingProduct[] = [
                    'product_name' => $product->product_name,
                    'product_image' => $product->main_image->name,
                    'total_sell' => $qty,
                    'total_sell_amount' => ($product->price * $qty),
                    'available_stock' => $product->product_qty,
                    'added_on' => $product->created_at,
                ];
            }

            $topSellingProduct  = $sellingProduct;

            return response()->json([
                'success' => true,
                'data' =>   $topSellingProduct,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }

    public function customer_index(Request $request)
    {

        try {

            $shopID = $request->header('shop_id');
            $orderIds = [];
            $orders = Order::with('order_details')->where('order_status', 'delivery')->where('shop_id', $shopID)->get();

            if (!$orders) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Order not Found',
                ], 404);
            }

            foreach ($orders as $order) {
                $orderIds[] = $order->id;
            }
            

            $orderDetails = OrderDetails::select('product_id', 'product_qty')->whereIn('order_id', $orderIds)->get();
            if (!$orderDetails) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Order Details not found',
                ], 404);
            }

            $sumArray = [];
            foreach ($orderDetails as $order) {
                if (!isset($sumArray[$order->product_id])) {
                    $sumArray[$order->product_id] = 0;
                }
                if (isset($sumArray[$order->product_id])) {
                    $sumArray[$order->product_id] += $order->product_qty;
                }
            }

            $sellingProduct = [];

            foreach ($sumArray as $key => $qty) {
                $product = Product::with('main_image')->where('id', $key)->first();

                $other_images = Media::where('parent_id',$product->id)->where('type', 'product_other_image')->get();
                $product['other_images']= $other_images;

                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'msg' =>  'Product not Found',
                    ], 404);
                }

                // $sellingProduct[] = [
                //     'product' => $product,
                //     'total_sell' => $qty,
                //     'total_sell_amount' => ($product->price * $qty),
                //     'available_stock' => $product->product_qty,
                //     'added_on' => $product->created_at,
                // ];

                $sellingProduct[] = $product;
            }

            $topSellingProduct  = $sellingProduct;

            return response()->json([
                'success' => true,
                'data' =>   $topSellingProduct,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }
}
