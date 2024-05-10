<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
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
        $schedule = Schedule::with(['order_of_business_information', 'committees' => [
            'lead_committee_information' => [
                'chairman_information',
                'vice_chairman_information',
            ],
            'display'
        ], 'schedule_venue'])->find($id);

        $schedule->committees = $schedule?->committees->sortBy('display.index');

        $settings = $this->settingRepository->getByNames('name', ['display_announcement', 'announcement_running_speed']);

        return inertia('ScreenDisplayIndex', [
            'id'                => $id,
            'data'              => $schedule,
            'sanggunianMembers' => $this->sanggunianMemberRepository->get(),
            'settings'          => $settings,
            'schedule'          => $schedule,
        ]);
    }
}
