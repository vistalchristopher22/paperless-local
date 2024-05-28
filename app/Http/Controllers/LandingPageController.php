<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\SanggunianMember;
use App\Repositories\SettingRepository;
use App\Repositories\ScheduleRepository;

final class LandingPageController extends Controller
{
    private readonly SettingRepository $settingRepository;
    private readonly ScheduleRepository $scheduleRepository;
    public function __construct(ScheduleRepository $scheduleRepository, SettingRepository $settingRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->settingRepository  = $settingRepository;
    }


    public function __invoke()
    {
        $date = date('d');
        $year = date('Y');
        $month = date('m');

        $schedule = Schedule::with('schedule_venue')
            ->with(['order_of_business_information' => ['file_link']])
            ->with([
                'with_guest_committees' => [
                    'file_link',
                    'lead_committee_information' => [
                        'chairman_information',
                        'vice_chairman_information',
                        'members' => ['sanggunian_member'],
                    ],
                    'expanded_committee_information',
                    'other_expanded_committee_information',
                ],
                'without_guest_committees' => [
                    'file_link',
                    'lead_committee_information' => [
                        'chairman_information',
                        'vice_chairman_information',
                        'members' => ['sanggunian_member'],
                    ],
                    'expanded_committee_information',
                    'other_expanded_committee_information',
                ],
            ])
            ->whereDay('date_and_time',  $date)
            ->whereYear('date_and_time', $year)
            ->whereMonth('date_and_time', $month)
            ->first();

        if(!$schedule) {
            return to_route("login");
        }

  
        $withGuests = $schedule->with_guest_committees->pluck('lead_committee_information')->toArray();
        $withoutGuests = $schedule->without_guest_committees->pluck('lead_committee_information')->toArray();

        $withGuestsChairmans     = data_get($withGuests, '*.chairman');
        $withGuestVicechairmans = data_get($withGuests, '*.vice_chairman');
        $withGuestMembers       = data_get($withGuests, '*.members.*.id');

        $withoutGuestsChairmans     = data_get($withoutGuests, '*.chairman');
        $withoutGuestVicechairmans = data_get($withoutGuests, '*.vice_chairman');
        $withoutGuestMembers       = data_get($withoutGuests, '*.members.*.id');


        $boardMembers = array_merge($withGuestsChairmans, $withGuestVicechairmans, $withGuestMembers);
        $boardMembers = array_merge($boardMembers, $withoutGuestsChairmans, $withoutGuestVicechairmans, $withoutGuestMembers);

        $boardMembers = array_values(array_unique(array_map('intval', $boardMembers)));

        $members = SanggunianMember::whereIn('id', $boardMembers)->get();

        return inertia('CommitteeMeetingSchedulePreview', [
            'schedule'            => $schedule,
            'settings'            => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'members'             => $members,
            'orderOfBusinessLink' =>  $schedule?->order_of_business_information?->file_link,
        ]);
    }
}
