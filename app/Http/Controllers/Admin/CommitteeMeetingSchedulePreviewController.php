<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanggunianMember;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use Inertia\Response;
use Inertia\ResponseFactory;

final class CommitteeMeetingSchedulePreviewController extends Controller
{
    private readonly ScheduleRepository $scheduleRepository;
    private readonly SettingRepository $settingRepository;
    public function __construct(ScheduleRepository $scheduleRepository, SettingRepository $settingRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->settingRepository  = $settingRepository;
    }

    /**
     * @param ScheduleRepository $scheduleRepository
     * @param string $date
     * @return Response|ResponseFactory
     */
    public function __invoke(string $date)
    {
        $schedule = $this->scheduleRepository->findByDate($date);

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
