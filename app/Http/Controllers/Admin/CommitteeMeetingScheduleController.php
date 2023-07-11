<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BoardSessionRespository;
use App\Repositories\CommitteeMeetingRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\FileUtility;
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

        $filePath = FileUtility::correctDirectorySeparator($latestPublishedBoardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = FileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $boardSessionPathForView = FileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(FileUtility::publicDirectoryForViewing() . FileUtility::changeExtension($fileName));

        return view('admin.committee-meeting.show', [
            'schedules' => $this->scheduleRepository->groupedByDate($dates),
            'boardSessionPathForView' => $boardSessionPathForView,
            'boardSession' => $latestPublishedBoardSession,
            'settings' => $this->settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ]);
    }
}
