<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('main_image')->where('shop_id', $request->header('shop-id'))->get();
        foreach ($products as $product) {
            $other_images = Media::query()->where('parent_id', $product->id)->where('type', 'product_other_image')->get();
            $product['other_images'] = $other_images;
            $allProduct[] = $product;
        }

        if ($products->isEmpty()) {
            return $this->sendApiResponse('', 'No Product Available', 'NotAvailable');
        }

        return $this->sendApiResponse($products);

    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $product = Product::with('main_image')
            ->where('shop_id', $request->header('shop-id'))
            ->where('id', $id)
            ->first();

        if (!$product) {
            return $this->sendApiResponse('', 'Product Not Found', 'NotFound');
        }

        $other_images = Media::query()
            ->where('parent_id', $product->id)
            ->where('type', 'product_other_image')
            ->get();

        $product['other_images'] = $other_images;
        return $this->sendApiResponse($product);

    }


    public function search(Request $request): JsonResponse
    {
        $query = Product::query()->with('main_image', 'other_images')->where('shop_id', $request->header('shop-id'));
        if ($request->filled('search')) {
            $query->where('product_name', 'LIKE', '%' . $request->input('search') . '%');
        }
        $products = $query->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'msg' => 'Product not found',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'data' => $products,
        ]);

    }
}
