<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ScreenDisplayRepositoryInterface;
use App\Enums\ScreenDisplayStatus;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

final class ScreenDisplayController extends Controller
{
    public function __construct(private readonly ScreenDisplayRepositoryInterface $screenDisplayRepository, private readonly SettingRepository $settingRepository)
    {
    }

    public function show(int $id)
    {
        return view('admin.screen-display.index', [
            'data' => $this->screenDisplayRepository->getByReferenceSession($id)->sortBy(fn ($model) => array_search($model->status, ScreenDisplayStatus::values()))->values(),
            'settingRepository' => $this->settingRepository,
        ]);
    }

    public function reOrder(Request $request)
    {
        $reOrdered = $this->screenDisplayRepository->reOrderDisplay($request->all());
        return response()->json(['success' => $reOrdered]);
    }
}
