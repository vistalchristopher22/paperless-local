<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\BoardSessionRespository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Support\Facades\Artisan;

final class DisplayScheduleController extends Controller
{
    private readonly BoardSessionRespository $boardSessionRespository;
    public function __construct()
    {
        $this->boardSessionRespository = app()->make(BoardSessionRespository::class);
    }
    public function __invoke(SettingRepository $settingRepository, ScheduleRepository $scheduleRepository, string $dates)
    {
//        $dates = explode('&', $dates);
//
//        return view('user.schedule.index', [
//            'schedules' => $scheduleRepository->groupedByDate($dates),
//            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
//            'dates' => implode('&', $dates),
//        ]);

        $dates = explode('&', $dates);
        $latestPublishedBoardSession = $this->boardSessionRespository->published();

        $filePath = CommitteeFileUtility::correctDirectorySeparator($latestPublishedBoardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $boardSessionPathForView = CommitteeFileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($fileName));

        return view('user.schedule.index', [
            'schedules' => $scheduleRepository->groupedByDate($dates),
            'boardSessionPathForView' => $boardSessionPathForView,
            'boardSession' => $latestPublishedBoardSession,
            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ]);
    }
}
