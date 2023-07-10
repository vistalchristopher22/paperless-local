<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardSession;
use App\Repositories\BoardSessionRespository;
use App\Repositories\CommitteeMeetingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

final class CommitteeMeetingScheduleController extends Controller
{
    private readonly BoardSessionRespository $boardSessionRespository;
    public function __construct(private readonly SettingRepository $settingRepository, private readonly ScheduleRepository $scheduleRepository)
    {
        $this->boardSessionRespository = app()->make(BoardSessionRespository::class);
    }

    public function store(CommitteeMeetingRepository $committeeMeetingRepository, Request $request)
    {
        $data = $request->all();
        $committeeMeetingRepository->addCommitteeMeetingToSchedule(scheduleId: $data['parent'], data: $data);

        return response()->json(['success' => true]);
    }

    public function show(string $dates)
    {
        $dates = explode('&', $dates);
        $latestPublishedBoardSession = $this->boardSessionRespository->published();

        $filePath = CommitteeFileUtility::correctDirectorySeparator($latestPublishedBoardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $boardSessionPathForView = CommitteeFileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($fileName));

        return view('admin.committee-meeting.show', [
            'schedules' => $this->scheduleRepository->groupedByDate($dates),
            'boardSessionPathForView' => $boardSessionPathForView,
            'boardSession' => $latestPublishedBoardSession,
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ]);
    }
}
