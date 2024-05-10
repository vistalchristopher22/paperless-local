<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeInvitedGuest;
use App\Repositories\AgendaRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\VenueRepository;

final class InvitedGuestsController extends Controller
{
    private AgendaRepository $agendaRepository;
    private ScheduleRepository $scheduleRepository;

    public function __construct()
    {
        $this->agendaRepository = app()->make(AgendaRepository::class);
    }

    public function __invoke()
    {
        $committeeInvitedGuests = CommitteeInvitedGuest::with([
            'committee:id,name,schedule_id,lead_committee',
            'committee.schedule_information.schedule_venue',
        ])->when(request()->search !== '', function ($query) {
            return $query->where('fullname', 'like', '%' . request()->search . '%');
        })->when(request()->agenda !== '' && !is_null(request()->agenda), function ($query) {
            return $query->whereHas('committee', function ($query) {
                return $query->where('lead_committee', request()->agenda);
            });
        })->when(request()->schedule !== '' && !is_null(request()->schedule), function ($query) {
            $query->whereHas('committee.schedule_information', function ($query) {
                [$reference_session, $type] = explode('-', request()->schedule);
                return $query->where('reference_session', trim($reference_session))->where('type', trim($type));
            });
        })->when(request()->venue && !is_null(request()->venue), function ($query) {
            return $query->whereHas('committee.schedule_information.schedule_venue', function ($query) {
                return $query->where('id', request()->venue);
            });
        })->paginate(8);

        return inertia('InvitedGuestsIndex', [
            'committeeInvitedGuests' => $committeeInvitedGuests,
            'search' => request()->search ?? '',
            'agendas' => $this->agendaRepository->get(),
            'schedules' => ScheduleRepository::getUniqueSchedules(),
            'venues' => VenueRepository::getUniqueVenues(),
            'venue' => request()->venue ?? '',
            'schedule' => request()->schedule ?? '',
            'agenda' => request()->agenda ?? '',
        ]);
    }
}
