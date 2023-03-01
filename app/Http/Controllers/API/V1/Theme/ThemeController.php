<?php

namespace App\Http\Controllers\API\V1\Theme;

use App\Http\Controllers\Controller;
use App\Models\ActiveTheme;
use App\Models\Shop;
use App\Models\Theme;
use App\Models\ThemeEdit;
use App\Models\ThemeImage;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    use sendApiResponse;

    public function getThemesByType(Request $request): JsonResponse
    {
        $query = Theme::query()->with('media');
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $themes = $query->orderByDesc('id')->get();
        if ($themes->isEmpty()) {
            return $this->sendApiResponse([], 'No Data found');
        }

        return $this->sendApiResponse($themes);
    }

    public function getListByPage(Request $request, $page): JsonResponse
    {
        $query = ThemeEdit::query()->with('gallery')
            ->where('shop_id', $request->header('shop-id'))
            ->where('page', $page)
            ->where('title', $request->input('title'))
            ->get();

        if ($query->isEmpty()) {
            return $this->sendApiResponse('', 'No data available');
        }

        foreach ($query as $key => $q) {
            $themes = Theme::query()->where('name', $q->theme)->get();
            $query[$key]['themes'] = $themes;
        }

        return $this->sendApiResponse($query);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => 'required',
            'page' => 'required',
            'theme' => 'nullable',
            'menu' => 'nullable',
        ]);
        $data['shop_id'] = $request->header('shop-id');
        if ($request->hasFile('logo')) {
            $file = $request->file('logo')->getClientOriginalName();
            $path = '/themes/images';
            $image = $request->file('logo')->storeAs($path, $file, 'local');
            $data['logo'] = $image;
        }
        $data['title'] = $request->input('title');
        $data['content'] = $request->input('content');

        $theme = ThemeEdit::query()->create($data);
        if ($request->input('gallery') !== null) {

            foreach (json_decode($request->input('gallery')) as $item) {

                $img = preg_replace('/^data:image\/\w+;base64,/', '', $item->file_name);
                $fileformat = explode(';', $item->file_name)[0];
                $type = explode('/', $fileformat)[1];

                $im = base64_decode($img);
                $file = time().'-gallery'.'.'.$type;
                $path = '/themes/images/gallery';

                Storage::disk('local')->put($path . '/' . $file, $im);

                ThemeImage::query()->create([
                    'theme_edit_id' => $theme->id,
                    'type' => $item->type,
                    'file_name' => $path.'/'.$file
                ]);

            }
        }
        $theme->load('gallery');


        return $this->sendApiResponse($theme, 'Data Created Successfully');
    }

    public function update(Request $request, $id): JsonResponse
    {

        $data = ThemeEdit::query()->findOrFail($id);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo')->getClientOriginalName();
            $path = '/themes/images';
            $image = $request->file('logo')->storeAs($path, $file, 'local');
            $data->logo = $image;
            $data->save();
        }
        if ($request->input('gallery') !== null) {
            $gallery = [];

            foreach (json_decode($request->input('gallery')) as $item) {

                if(Str::contains($item->file_name, 'base64')){

                    $img = preg_replace('/^data:image\/\w+;base64,/', '', $item->file_name);

                    $fileformat = explode(';', $item->file_name)[0];
                    $type = explode('/', $fileformat)[1];

                    $im = base64_decode($img);
                    $file = time().'-gallery'.'.'.$type;
                    $path = '/themes/images/gallery';

                    Storage::disk('local')->put($path . '/' . $file, $im);
                    $image = [
                        'type' => $item->type,
                        'file_name' => $path.'/'.$file
                    ];
                    array_push($gallery, $image);

                } else {
                    $image = [
                        'type' => $item->type,
                        'file_name' => $item->file_name
                    ];
                    array_push($gallery, $image);
                }

            }
            $old_gallery = ThemeImage::query()->where('theme_edit_id', $id)->get();


            if($old_gallery->isNotEmpty()) {
                foreach($old_gallery as $old_image){
                    $old_image->delete();
                }
            }
            foreach($gallery as $gimage)  {

                ThemeImage::query()->create([
                    'theme_edit_id' => $id,
                    'type' => $gimage['type'],
                    'file_name' => $gimage['file_name']
                ]);
            }
        }

        $data->update($request->except('logo', 'gallery'));
        $data->load('gallery');

        return $this->sendApiResponse($data, 'Data Updated Successfully');
    }

    public function import(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required'],
            'theme_id' => ['required'],
        ]);
        $theme = Theme::query()->where('id', $request->input('theme_id'))->first();


        if (!$theme) {
            return $this->sendApiResponse('', 'Theme not available right now', 'themeNotFound', [], 401);
        }

        if ($theme->type === 'multiple') {
            $import = ActiveTheme::query()->where('shop_id', $request->header('shop-id'))->where('type', 'multiple')->first();
            if (!$import) {
                $import = new ActiveTheme();
            }
            $import->shop_id = $request->header('shop-id');
            $import->theme_id = $theme->id;
            $import->type = 'multiple';
            $import->save();
            $import->load(['theme', 'theme.media']);
        } else {
            $import = ActiveTheme::query()->updateOrCreate([
                'shop_id' => $request->header('shop-id'),
                'theme_id' => $theme->id,
                'type' => $request->input('type')
            ]);
            $import->load(['theme', 'theme.media']);
        }

        return $this->sendApiResponse($import, 'Theme Imported Successfully');
    }


    public function getMerchantsTheme(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required']
        ]);

        $shop = Shop::query()->where('shop_id', $request->header('shop-id'))->first();

        if (!$shop) {
            throw ValidationException::withMessages([
                'shop_id' => 'Invalid Shop Id'
            ]);
        }
        $active_themes = ActiveTheme::query()->where('shop_id', $shop->shop_id)->pluck('theme_id');
        ActiveTheme::query()->where('shop_id', $shop->shop_id)->pluck('page_id');

        $theme = Theme::query()->with('media')->with('page')->where('type', $request->input('type'))->whereIn('id', $active_themes)->get();


        if ($theme->isEmpty()) {
            return $this->sendApiResponse('', 'No theme has been imported', 'themeNotFound', []);
        }
        return $this->sendApiResponse($theme);
    }
}
