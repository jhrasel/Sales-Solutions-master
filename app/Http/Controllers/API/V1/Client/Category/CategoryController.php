<?php

namespace App\Http\Controllers\API\V1\Client\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $categories = Category::query()->with('subcategory', 'category_image')
            ->where('parent_id', 0)
            ->where('shop_id', $request->header('shop_id'))
            ->orderByDesc('id')
            ->get();
        if ($categories->isEmpty()) {
            return $this->sendApiResponse('', 'No data available', 'NotAvailable');
        }
        return $this->sendApiResponse($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $query = Category::query()->where('shop_id', $request->header('shop_id'))->where('name', $request->input('name'))->first();
        if ($query) {
            throw validationException::withMessages(['category' => 'This category already exist']);
        }
        $data = $request->except('category_image');
        $data['slug'] = Str::slug($request->name);
        $data['shop_id'] = $request->header('shop_id');
        $data['parent_id'] = $request->input('parent_id') ?: 0;
        $data['user_id'] = auth()->user()->id;
        $category = Category::query()->create($data);

        if ($request->hasFile('category_image')) {
            //store category image
            $imageName = time() . '.' . $request->file('category_image')->getClientOriginalExtension();
            $request->file('category_image')->move(public_path('images/category'), $imageName);
            $media = new Media();
            $media->name = 'images/category/' . $imageName;
            $media->parent_id = $category->id;
            $media->type = 'category';
            $media->save();
        }
        $category->load('category_image');
        return $this->sendApiResponse($category, 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        $category = Category::with('category_image', 'subcategory')
            ->where('id', $id)
            ->where('shop_id', $request->header('shop_id'))
            ->first();
        if (!$category) {
            return $this->sendApiResponse('', 'No category found');
        }
        return $this->sendApiResponse($category);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $category = Category::query()->with('category_image')->find($id);
        if (!$category) {
            return $this->sendApiResponse('', 'No category found');
        }
        $data = $request->except('category_image');
        if ($request->filled('name')) {
            $data['slug'] = Str::slug($request->input('name'));
        }
        $category->update($data);

        if ($request->has('category_image')) {

            if($category->category_image !== null) {
                $image_path = $category->category_image->name;
                File::delete(public_path($image_path));
            }


            $imageName = time() . '.' . $request->file('category_image')->getClientOriginalExtension();
            $request->file('category_image')->move(public_path('images/category'), $imageName);
            $media = Media::query()->where('type', 'category')->where('parent_id', $category->id)->update([
                'name' => 'images/category/' . $imageName,
            ]);
        }
        $category->load('category_image');

        return $this->sendApiResponse($category, 'category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $category = Category::with('category_image')->find($id);

        if (!$category) {
            return $this->sendApiResponse('', 'Category not found', 'NotFound');
        }
        if ($category->category_image !== null) {
            File::delete(public_path($category->category_image->name));
            $category->category_image->delete();
        }

        $category->delete();
        return $this->sendApiResponse('', 'Category deleted successfully');

    }

}