<?php

namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = setting::first();
        return view('admin.setting.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = setting::first();
        $data = $request->except(['_token', '_method']);

        $images = [
            'favicon', 'mainLogo', 'whiteLogo',
            'slider1_image', 'slider1_thumb',
            'slider2_image', 'slider2_thumb',
            'slider3_image', 'slider3_thumb',
            'banner1_image', 'banner2_image', 'banner3_image', 'banner4_image', 'banner5_image'
        ];

        foreach ($images as $imageField) {
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $filename = time() . '_' . $imageField . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/settings'), $filename);
                $data[$imageField] = 'uploads/settings/' . $filename;
            }
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
