<?php

namespace App\Http\Controllers\API\V1\Client\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Media;
use App\Models\Slider;
use Illuminate\Http\Request;
use DB, File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $sliders  = Slider::with('slider_image')->get();
            return response()->json([
                'success' => true,
                'data' => $sliders,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>  $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        try {
            DB::beginTransaction();
            $slider = new Slider();
            $slider->title = $request->title;
            $slider->description = $request->description;
            $slider->shop_id = 1;
            $slider->user_id = 1;
            $slider->save();

            //store category image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $media = new Media();
            $media->name = '/images/' . $imageName;
            $media->parent_id = $slider->id;
            $media->type = 'merchant_slider';
            $media->save();
            DB::commit();
            $slider['image'] = $media->name;

            return response()->json([
                'success' => true,
                'msg' => 'Slider created Successfully',
                'data' =>   $slider,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $slider = Slider::with('slider_image')->where('id', $id)->first();
            if (!$slider) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Slider not Found',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' =>   $slider,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $slider = Slider::with('slider_image')->find($id);
            if (!$slider) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Slider not Found',
                ], 404);
            }

            $slider->title = $request->title;
            $slider->description = $request->description;
            $slider->shop_id = 1;
            $slider->user_id = 1;
            $slider->save();
            
            if ($request->has('image')) {
                $image_path = $slider->slider_image->name;
                File::delete(public_path($image_path));

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $media = Media::where('type', 'merchant_slider')->where('parent_id', $slider->id)->update([
                    'name' => '/images/' . $imageName
                ]);
            }
            $updatedSlider = Slider::with('slider_image')->where('id',$id)->first();
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Slider updated successfully',
                'data' =>   $updatedSlider,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $slider = Slider::with('slider_image')->find($id);
            if (!$slider) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Slider not Found',
                ], 404);
            }
            File::delete(public_path($slider->slider_image->name));
            $slider->slider_image->delete();
            $slider->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Slider Deleted Successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }
}
