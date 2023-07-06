<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

final class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::get();

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $setting => $value) {
            Setting::updateOrCreate(
                [
                    'name' => $setting,
                ],
                [
                    'name' => $setting,
                    'value' => $value,
                ]
            );
        }

        return to_route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
