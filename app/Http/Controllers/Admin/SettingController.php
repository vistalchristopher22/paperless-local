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
        return inertia('SettingIndex', [
            'settings' => $this->settingRepository->getByNames('name', [
                'display_announcement',
                'announcement_running_speed',
                'source_folder',
                'prepared_by',
                'noted_by',
                'libre_office_path',
                'network_source_path',
                'server_socket_url',
                'local_socket_url',
            ])->pluck('name', 'value')->flip()
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->settingRepository->updateNewSettings($data);
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
