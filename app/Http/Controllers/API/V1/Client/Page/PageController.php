<?php

namespace App\Http\Controllers\API\V1\Client\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\ActiveTheme;
use App\Models\Page;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageController extends Controller
{
    use sendApiResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = Page::query()->with('product', 'product.main_image', 'product.other_images')->where('shop_id', $request->header('shop-id'))->get();
        if ($page->isEmpty()) {
            return $this->sendApiResponse('', 'No data available right now', 'NotAvailable');
        }
        return $this->sendApiResponse($page);
    }


    public function create()
    {

    }


    /**
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function store(PageRequest $request): JsonResponse
    {
        $page = new Page();
        $page->user_id = auth()->user()->id;
        $page->shop_id = $request->header('shop-id');
        $page->title = $request->input('title');
        $page->slug = Str::slug($request->input('title'));
        $page->page_content = $request->input('page_content');
        $page->theme = $request->input('theme');
        $page->status = $request->input('status') ?: 1;
        $page->product_id = $request->input('product_id');
        $page->save();
        $page->load('product');

        if (!$page) {
            return $this->sendApiResponse('', 'Something went wrong', 'UnknownError');
        }
        return $this->sendApiResponse($page, 'Page created successfully');

    }


    /**
     * @param Request $request
     * @param $slug
     * @return JsonResponse
     */
    public function show(Request $request, $slug): JsonResponse
    {
        $page = Page::query()->with('product', 'product.main_image', 'product.other_images')
            ->where('slug', $slug)
            ->where('shop-id', $request->header('shop-id'))
            ->first();
        if (!$page) {
            return $this->sendApiResponse('', 'Page not Found', 'NotFound');
        }
        return $this->sendApiResponse($page);
    }


    public function edit($id)
    {

    }

    /**
     * @param PageRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(PageRequest $request, $id): JsonResponse
    {
        $page = Page::query()->find($id);
        if (!$page) {
            return $this->sendApiResponse('', 'Page Not found', 'NotFound');
        }
        $page->title = $request->input('title');
        $page->slug = Str::slug($request->input('title'));
        $page->page_content = $request->input('page_content');
        $page->theme = $request->input('theme');
        $page->product_id = $request->input('product_id') ?: $page->product_id;
        $page->save();
        $page->load('product');

        return $this->sendApiResponse($page, 'Page updated successfully');
    }


    public function destroy($id): JsonResponse
    {
        $page = Page::query()->find($id);
        if (!$page) {
            return $this->sendApiResponse('', 'Page not found', 'NotFound');
        }
        $theme = ActiveTheme::query()->where('theme_id', $page->theme)->where('shop_id', request()->header('shop-id'))->first();
        $theme->delete();
        $page->delete();
        return $this->sendApiResponse('', 'Page deleted successfully');

    }
}