<?php

namespace App\Http\Controllers\API\V1\Client\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        $products = Product::query()->with('main_image', 'other_images')
            ->where('shop_id', $request->header('shop-id'))
            ->orderByDesc('id')
            ->get();

        if ($products->isEmpty()) {
            return $this->sendApiResponse('', 'No Data available');
        }
        return $this->sendApiResponse($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        if(!$request->input('category_id')) {

            $category = new Category;
            $category->name = $request->input('category_name');
            $category->slug = Str::slug($request->input('category_name'));
            $category->user_id = auth()->user()->id;
            $category->shop_id = $request->header('shop-id');
            $category->status = 1;
            $category->save();

            $category_id = $category->id;

        } else {
            $category_id = $request->category_id;
        }
        $product->category_id = $category_id;
        $product->user_id = auth()->user()->id;
        $product->shop_id = auth()->user()->shop->shop_id;
        $product->product_name = $request->product_name;
        $product->slug = Str::slug($request->product_name);
        $product->price = $request->price;
        $product->product_code = $request->product_code;
        $product->product_qty = $request->product_qty;
        $product->discount = $request->discount;
        $product->short_description = $request->short_description;
        $product->delivery_charge = $request->input('delivery_charge');

        if($request->input('delivery_charge') === 'paid') {
            $product->inside_dhaka = $request->input('inside_dhaka');
            $product->outside_dhaka = $request->input('outside_dhaka');
        } else {
            $product->inside_dhaka = 0;
            $product->outside_dhaka = 0;
        }
        $product->save();

        //store product main image
        $mainImageName = time() . '_main_image.' . $request->main_image->extension();
        $request->main_image->move(public_path('images'), $mainImageName);
        $media = new Media();
        $media->name = '/images/' . $mainImageName;
        $media->parent_id = $product->id;
        $media->type = 'product_main_image';
        $media->save();

        $product['main_image'] = $media->name;


        if ($request->hasFile('other_image')) {

            foreach ($request->other_image as $key => $image) {
                //store product other image
                $otherImageName = time() . rand(1000, 9999) . '_other_image.' . $image->extension();
                $image->move(public_path('images'), $otherImageName);
                $mediaOther = new Media();
                $mediaOther->name = '/images/' . $otherImageName;
                $mediaOther->parent_id = $product->id;
                $mediaOther->type = 'product_other_image';
                $mediaOther->save();
                $product['other_image_' . $key] = $mediaOther->name;
            }
        }

        return $this->sendApiResponse($product, 'Product created successfully');
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
        $product = Product::query()->with('main_image')
            ->where('shop_id', $request->header('shop-id'))
            ->where('id', $id)
            ->first();
        $other_images = Media::query()->where('parent_id', $product->id)
            ->where('type', 'product_other_image')
            ->get();
        $product['other_images'] = $other_images;
        if (!$product) {
            return $this->sendApiResponse('', 'No Data available', 'NotFound');
        }
        return $this->sendApiResponse($product);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $product = Product::with('main_image')->find($id);
            if (!$product) {
                return $this->sendApiResponse('', 'Product Not Found', 'NotFound');
            }
            $product->category_id = $request->category_id;
            $product->product_name = $request->product_name;
            $product->slug = Str::slug($request->product_name);
            $product->price = $request->price;
            $product->product_code = $request->product_code;
            $product->product_qty = $request->product_qty;
            $product->discount = $request->discount;
            $product->short_description = $request->short_description;
            $product->status = $request->status ? $request->status : $product->status;

            $product->delivery_charge = $request->input('delivery_charge');

            if($request->input('delivery_charge') === 'paid') {
                $product->inside_dhaka = $request->input('inside_dhaka');
                $product->outside_dhaka = $request->input('outside_dhaka');
            } else {
                $product->inside_dhaka = 0;
                $product->outside_dhaka = 0;
            }

            $product->save();

            if ($request->has('main_image')) {

                $image_path = $product->main_image->name;
                File::delete(public_path($image_path));

                $imageName = time() . '_main_image.' . $request->main_image->extension();
                $request->main_image->move(public_path('images'), $imageName);
                $media = Media::where('type', 'product_main_image')->where('parent_id', $product->id)->update([
                    'name' => '/images/' . $imageName
                ]);


            }
            $updatedProduct = Product::with(['main_image'])->where('id', $id)->first();
            DB::commit();
            return $this->sendApiResponse($updatedProduct, 'Product Updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendApiResponse('', $e->getMessage(), 'Exception');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $product = Product::with(['main_image'])->find($id);
        if (!$product) {
            return $this->sendApiResponse('', 'Product Not Found', 'NotFound');
        }
        if ($product->main_image) {
            File::delete(public_path($product->main_image->name));
            $product->main_image->delete();
        }

        $other_images = Media::query()->where('parent_id', $product->id)->where('type', 'product_other_image')->get();

        if (count($other_images) > 0) {
            foreach ($other_images as $image) {
                File::delete(public_path($image->name));
                $image->delete();
            }

        }
        $product->delete();
        return $this->sendApiResponse('', 'Product Removed Successfully');

    }
}
