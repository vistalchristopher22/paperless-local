<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CommitteeMeetingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use App\Utilities\FileUtility;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class CommitteeMeetingScheduleController extends Controller
{
    public function __construct(private readonly SettingRepository $settingRepository, private readonly ScheduleRepository $scheduleRepository)
    {
    }

    public function store(CommitteeMeetingRepository $committeeMeetingRepository, Request $request)
    {
        return DB::transaction(function () use ($request, $committeeMeetingRepository) {

            $data = $request->all();

            $schedule = $this->scheduleRepository->findById($data['parent']);

            $draggedCommittee = $committeeMeetingRepository->findById($data['id'])->load('lead_committee_information');
            $committeeMeetingRepository->addCommitteeMeetingToSchedule($data['parent'], $data);

            return response()->json(['success' => true]);
        });
    }

    public function show(string $date)
    {

        $arrayDates = explode(separator: "&", string: $date);

        // $records    = $this->scheduleRepository->groupedByDate($arrayDates);

        // $recordTypes = $records->pluck('*.type')->flatten()->flip();

        // if ($recordTypes->has('session') && !$recordTypes->has('committee')) {
        //     return to_route("committee-meeting.schedule.show.session-only", $dates);
        // }

        // if ($recordTypes->has('session') && $recordTypes->has('committee')) {
        //     return to_route("committee-meeting.schedule.show.committees-and-session", $dates);
        // }

        $schedule = $this->scheduleRepository->findByDate($date);
        return view('admin.committee-meeting.show', [
            'schedule' => $schedule,
            'settings'  => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates'   => $arrayDates,
        ]);
    }

    public function sessions($dates): View
    {
        $dates   = explode(separator: "&", string: $dates);
        $records = $this->scheduleRepository->groupedByDate($dates);
        return view('admin.committee-meeting.session-display', [
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates'    => implode('&', $dates),
            'records'  => $records,
        ]);
    }

    public function committeesAndSession($dates): View
    {
        $dates              = explode(separator: "&", string: $dates);
        $records            = $this->scheduleRepository->groupedByDate($dates);
        $groupByDateAndType = $records->map(fn ($record) => $record->groupBy(fn ($data) => $data->type . " | " . $data->venue));
        $groupByDateAndType = $groupByDateAndType->sortBy(fn ($item, $key) => strtotime($key));

        return view('admin.committee-meeting.session-and-committee-display', [
            'settings'           => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates'              => implode('&', $dates),
            'records'            => $records,
            'groupByDateAndType' => $groupByDateAndType,
        ]);
    }

    private function organizeCommitteeAttachments(array $data, $baseDirectory): void
    {
        foreach ($data['attachments'] as &$attachment) {
            if (count($attachment) > 0) {
                $newLocation = dirname($baseDirectory);
                if (isset($attachment['file_path'])) {
                    rename($attachment['file_path'], FileUtility::correctDirectorySeparator($newLocation) . DIRECTORY_SEPARATOR . basename($attachment['file_path']));
                    $this->organizeCommitteeAttachments($attachment, $baseDirectory);
                }
            }
        }
    }
}
