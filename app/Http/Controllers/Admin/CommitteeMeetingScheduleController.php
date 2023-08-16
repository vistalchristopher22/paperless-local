<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CommitteeMeetingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use App\Utilities\FileUtility;
use Error;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

            $scheduleRootDirectory = $schedule->root_directory;

            $draggedCommittee = $committeeMeetingRepository->findById($data['id'])->load('lead_committee_information');

            $newLocation = (FileUtility::correctDirectorySeparator($scheduleRootDirectory . DIRECTORY_SEPARATOR . "COMMITTEES" . DIRECTORY_SEPARATOR . Str::replace([" ", "-", "/"], "_", $draggedCommittee->lead_committee_information->title) . DIRECTORY_SEPARATOR . basename($draggedCommittee->file_path)));
            $newFolderDestination = (FileUtility::correctDirectorySeparator($scheduleRootDirectory . DIRECTORY_SEPARATOR . "COMMITTEES" . DIRECTORY_SEPARATOR . Str::replace([" ", "-", "/"], "_", $draggedCommittee->lead_committee_information->title) . DIRECTORY_SEPARATOR));

            if (!file_exists($newFolderDestination)) {
                if (!mkdir(($newFolderDestination), 0777, true) && !is_dir($newFolderDestination)) {
                    throw new Error(sprintf('Directory "%s" was not created', $newFolderDestination));
                }
            }

            copy(FileUtility::correctDirectorySeparator($draggedCommittee->file_path), $newLocation);

            $draggedCommittee->update([
                'file_path' => $newLocation,
            ]);

            $committeeMeetingRepository->addCommitteeMeetingToSchedule(scheduleId: $data['parent'], data: $data);

            $directory = base_path();
            $path = FileUtility::isInputDirectoryEscaped($draggedCommittee->file_path);
            $output = shell_exec('python.exe ' . $directory . '\\parser.py -f "' . $path . '"');

            $attachments = json_decode($output, true, 512, JSON_THROW_ON_ERROR);

            $draggedCommittee->update([
                'file_map' => json_encode($attachments),
            ]);

            $this->organizeCommitteeAttachments($attachments, $draggedCommittee->file_path);

            return response()->json(['success' => true]);
        });
    }

    private function organizeCommitteeAttachments(array &$data, $baseDirectory): void
    {
        foreach ($data['attachments'] as $attachment) {
            if (count($attachment) > 0) {
                $newLocation = dirname($baseDirectory);
                if (isset($attachment['file_path'])) {
                    copy($attachment['file_path'], FileUtility::correctDirectorySeparator($newLocation) . DIRECTORY_SEPARATOR . basename($attachment['file_path']));
                    $this->organizeCommitteeAttachments($attachment, $baseDirectory);
                }
            }
        }
    }

    public function show(string $dates)
    {
        $arrayDates = explode(separator: "&", string: $dates);
        $records = $this->scheduleRepository->groupedByDate($arrayDates);

        $recordTypes = $records->pluck('*.type')->flatten()->flip();

        if ($recordTypes->has('session') && !$recordTypes->has('committee')) {
            return to_route("committee-meeting.schedule.show.session-only", $dates);
        }

        if ($recordTypes->has('session') && $recordTypes->has('committee')) {
            return to_route("committee-meeting.schedule.show.committees-and-session", $dates);
        }

        return view('admin.committee-meeting.show', [
            'schedules' => $records->sort(),
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $arrayDates),
        ]);

    }

    public function sessions($dates): View
    {
        $dates = explode(separator: "&", string: $dates);
        $records = $this->scheduleRepository->groupedByDate($dates);
        return view('admin.committee-meeting.session-display', [
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
            'records' => $records,
        ]);
    }

    public function committeesAndSession($dates): View
    {
        $dates = explode(separator: "&", string: $dates);
        $records = $this->scheduleRepository->groupedByDate($dates);
        $groupByDateAndType = $records->map(fn($record) => $record->groupBy(fn($data) => $data->type . " | " . $data->venue));
        $groupByDateAndType = $groupByDateAndType->sortBy(fn($item, $key) => strtotime($key));

        return view('admin.committee-meeting.session-and-committee-display', [
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
            'records' => $records,
            'groupByDateAndType' => $groupByDateAndType,
        ]);
    }

}
