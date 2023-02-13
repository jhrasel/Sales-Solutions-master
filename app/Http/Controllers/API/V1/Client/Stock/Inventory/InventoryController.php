<?php

namespace App\Http\Controllers\API\V1\Client\Stock\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Media;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InventoryController extends Controller
{
    use sendApiResponse;

    public function index(Request $request): JsonResponse
    {
        $products = Product::query()->with('main_image', 'other_images')
            ->where('shop_id', $request->header('shop-id'))
            ->orderByDesc('id')
            ->get();
        if ($products->isEmpty()) {
            return $this->sendApiResponse('', 'No products available', 'NotAvailable');
        }
        return $this->sendApiResponse($products);

    }

    public function show(Request $request, $id): JsonResponse
    {
        $product = Product::query()->with('main_image', 'other_images')
            ->where('id', $id)
            ->where('shop_id', $request->header('shop-id'))
            ->first();
        if (!$product) {
            return $this->sendApiResponse('', 'Product not Found', 'NotFound');
        }
        return $this->sendApiResponse($product, 'Product not Found', 'NotFound');

    }

    public function update(ProductRequest $request): JsonResponse
    {
        $product = Product::query()->with('main_image')
            ->where('id', $request->input('product_id'))
            ->where('shop_id', $request->header('shop-id'))
            ->first();
        if (!$product) {
            return $this->sendApiResponse('', 'Product not Found', 'NotFound');
        }
        if ($request->input('product_name') !== null) {
            $product->product_name = $request->input('product_name');
        }
        if ($request->input('product_code') !== null) {
            $product->product_code = $request->input('product_code');
        }
        if ($request->input('selling_price') !== null) {
            $product->price = $request->input('selling_price');
        }

        $product->save();

        if ($request->has('main_image')) {

            $image_path = $product->main_image->name;
            File::delete(public_path($image_path));

            $imageName = time() . '_main_image.' . $request->main_image->extension();
            $request->main_image->move(public_path('images'), $imageName);
            Media::query()->where('type', 'product_main_image')->where('parent_id', $product->id)->update([
                'name' => '/images/' . $imageName
            ]);
        }
        return $this->sendApiResponse($product, 'Inventory updated successfully');

    }
}
