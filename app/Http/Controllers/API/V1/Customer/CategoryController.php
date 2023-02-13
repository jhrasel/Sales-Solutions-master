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
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        try {

            $shopId = $request->header('shop_id');
            $category = Category::with('category_image')->where('shop_id', $shopId)->get();
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Category not Found',
                ], 404);
            }

            $categories = $this->getCategoryTreeForParentId(0,$shopId);


            return response()->json([
                'success' => true,
                'data' =>   $categories,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show(Request $request, $slug)
    {
        try {

            $shopId = $request->header('shop_id');
            $category = Category::with('category_image')->where('slug', $slug)->where('shop_id', $shopId)->first();
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Category not Found',
                ], 404);
            }

            $categories = $this->getCategoryTreeForParentId($category->id,$shopId);


            return response()->json([
                'success' => true,
                'data' =>   $categories,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
        //return $this->sendApiResponse($category);
    }

    public function getCategoryTreeForParentId($parent_id=0,$shopID)
    {
        $categories = array();

        $result = Category::where('parent_id', $parent_id)->where('shop_id',$shopID)->get();
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
            $category['sub_categories'] = $this->getCategoryTreeForParentId($category['id'],$category['shop_id']);
            $categories[] = $category;
        }
        return $categories;
    }
    
}
