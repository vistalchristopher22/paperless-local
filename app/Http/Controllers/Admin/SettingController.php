<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

final class SettingController extends Controller
{
    public function __construct(private readonly SettingRepository $settingRepository)
    {
    }

    public function index()
    {
        return view('admin.settings.index', [
            'settings' => $this->settingRepository->get(),
            'settingRepository' => $this->settingRepository,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->settingRepository->updateNewSettings($data);
        return to_route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
