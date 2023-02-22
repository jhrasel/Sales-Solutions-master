<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use sendApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $category = Category::query()->with('category_image')->where('shop_id', $request->header('shop-id'))->get();
        if (!$category) {
            return response()->json([
                'success' => false,
                'msg' => 'Category not Found',
            ], 200);
        }

        $categories = $this->getCategoryTreeForParentId(0, $request->header('shop-id'));
        return response()->json([
            'success' => true,
            'data' => $categories,
        ], 200);

    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $slug
     * @return JsonResponse
     */
    public function show(Request $request, $slug): JsonResponse
    {
        $category = Category::query()->with('category_image')
            ->where('slug', $slug)
            ->where('shop_id', $request->header('shop-id'))
            ->first();
        if (!$category) {
            return response()->json([
                'success' => false,
                'msg' => 'Category not Found',
            ], 404);
        }

        $categories = $this->getCategoryTreeForParentId($category->id, $request->header('shop-id'));

        return response()->json([
            'success' => true,
            'data' => $categories,
        ], 200);

    }

    public function getCategoryTreeForParentId($shopID, $parent_id = 0): array
    {
        $categories = array();
        $result = Category::query()->where('parent_id', $parent_id)->where('shop_id', $shopID)->get();
        foreach ($result as $mainCategory) {
            $category = array();
            $category['id'] = $mainCategory->id;
            $category['name'] = $mainCategory->name;
            $category['slug'] = $mainCategory->slug;
            $category['image'] = $mainCategory->category_image;
            $category['description'] = $mainCategory->description;
            $category['shop_id'] = $mainCategory->shop_id;
            $category['parent_id'] = $mainCategory->parent_id;
            $category['status'] = $mainCategory->status;
            $category['sub_categories'] = $this->getCategoryTreeForParentId($category['id'], $category['shop_id']);
            $categories[] = $category;
        }
        return $categories;
    }

}
