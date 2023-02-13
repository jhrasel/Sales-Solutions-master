<?php /** @noinspection PhpUnhandledExceptionInspection */

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\API\V1\Theme;

use App\Http\Controllers\Controller;
use App\Models\ActiveTheme;
use App\Models\Shop;
use App\Models\Theme;
use App\Models\ThemeEdit;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        $query = ThemeEdit::query()->where('shop_id', $request->header('shop_id'))->where('page', $page)->get();

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
            'theme' => 'nullable'
        ]);
        $data['shop_id'] = $request->header('shop_id');
        if ($request->hasFile('logo')) {
            $file = $request->file('logo')->getClientOriginalName();
            $path = '/themes/images';
            $image = $request->file('logo')->storeAs($path, $file, 'local');
            $data['logo'] = $image;
        }
        $data['title'] = $request->input('title');
        $data['content'] = $request->input('content');

        $theme = ThemeEdit::query()->create($data);

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

        $data->update($request->except('logo'));

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
            $import = ActiveTheme::query()->where('shop_id', $request->header('shop_id'))->where('type', 'multiple')->first();
            if (!$import) {
                $import = new ActiveTheme();
            }
            $import->shop_id = $request->header('shop_id');
            $import->theme_id = $theme->id;
            $import->type = 'multiple';
            $import->save();
            $import->load(['theme', 'theme.media']);
        } else {
            $import = ActiveTheme::query()->updateOrCreate([
                'shop_id' => $request->header('shop_id'),
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

        $shop = Shop::query()->where('shop_id', $request->header('shop_id'))->first();

        if (!$shop) {
            throw ValidationException::withMessages([
                'shop_id' => 'Invalid Shop Id'
            ]);
        }
        $active_themes = ActiveTheme::query()->where('shop_id', $shop->shop_id)->pluck('theme_id');
        $theme = Theme::query()->with('media')->where('type', $request->input('type'))->whereIn('id', $active_themes)->get();

        if ($theme->isEmpty()) {
            return $this->sendApiResponse('', 'No theme has been imported', 'themeNotFound', []);
        }
        return $this->sendApiResponse($theme);
    }
}
