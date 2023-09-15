<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\SanggunianMemberRepository;
use App\Contracts\ScreenDisplayRepositoryInterface;

final class ScreenDisplayController extends Controller
{
    private readonly ScreenDisplayRepositoryInterface $screenDisplayRepository;
    private readonly SettingRepository $settingRepository;
    private readonly SanggunianMemberRepository $sanggunianMemberRepository;

    public function __construct()
    {
        $this->screenDisplayRepository    = app()->make(ScreenDisplayRepositoryInterface::class);
        $this->settingRepository          = app()->make(SettingRepository::class);
        $this->sanggunianMemberRepository = app()->make(SanggunianMemberRepository::class);
    }

    public function __invoke(int $id)
    {
        return view('admin.screen-display.index', [
            'id'                => $id,
            'data'              => $this->screenDisplayRepository->getSortedByReferenceSession($id),
            'sanggunianMembers' => $this->sanggunianMemberRepository->get(),
            'settingRepository' => $this->settingRepository,
        ]);
    }
}
