<?php

namespace App\Http\Controllers\API\V1\Client\Stock\StockIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Media;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        try {

            $merchant = User::where('role', 'merchant')->find(auth()->user()->id);
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $allProduct = [];
            $products = Product::with('main_image')->where('shop_id', $merchant->shop->id)->get();
            foreach ($products as $product) {
                $other_images = Media::where('parent_id', $product->id)->where('type', 'product_other_image')->get();
                $allProduct[] = $product;
            }
            return response()->json([
                'success' => true,
                'data' => $allProduct,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        try {

            $merchant = User::where('role', 'merchant')->find(auth()->user()->id);
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $product = Product::with('main_image')->where('id', $id)->where('shop_id', $merchant->shop->id)->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Product not Found',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }

    public function update(ProductRequest $request): JsonResponse
    {
        $product = Product::with('main_image', 'other_images')->where('id', $request->input('product_id'))
            ->where('shop_id', $request->header('shop-id'))
            ->first();
        if (!$product) {
            return $this->sendApiResponse('', 'Product Not found', 'NotFound');
        }

        if ($request->input('stock_quantity') != null) {
            $product->product_qty = ($product->product_qty + $request->input('stock_quantity'));
        }

        $product->save();
        return $this->sendApiResponse($product, 'Updated Successfully');
    }
}
