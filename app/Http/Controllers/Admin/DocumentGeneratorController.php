<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\SanggunianMember;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SanggunianMemberRepository;

final class DocumentGeneratorController extends Controller
{
    private ScheduleRepository $scheduleRepository;
    private SettingRepository $settingRepository;
    private SanggunianMemberRepository $sanggunianMemberRepository;
    public function __construct()
    {
        $this->scheduleRepository = app()->make(ScheduleRepository::class);
        $this->settingRepository = app()->make(SettingRepository::class);
        $this->sanggunianMemberRepository = app()->make(SanggunianMemberRepository::class);
    }
    public function __invoke(int $id)
    {
        $schedule = $this->scheduleRepository->findById($id)
                            ->load([
                                'schedule_venue',
                                'attendance_logs_present',
                                'attendance_logs_absent',
                                'attendance_logs_on_official_business',
                                'attendance_logs_late',
                                'attendance_on_sick_leave'
                        ]);

        $currentPresidingOfficer = Setting::where('name', 'presiding_officer')->first();
        
        $sanggunianMembers = $this->sanggunianMemberRepository->get();

        return inertia('Generate', [
            'schedule'          => $schedule,
            'presidingOfficer'  => $currentPresidingOfficer,
            'sanggunianMembers' => $sanggunianMembers, 
        ]);
    }
}
