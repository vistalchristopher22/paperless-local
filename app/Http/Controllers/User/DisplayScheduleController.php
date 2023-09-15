<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\BoardSessionRespository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SettingRepository;
use App\Resolvers\PDFLinkResolver;
use App\Utilities\FileUtility;
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

        $filePath = FileUtility::correctDirectorySeparator($latestPublishedBoardSession->file_path);

        $fileName = basename($filePath);

        $outputDirectory = FileUtility::publicDirectoryForViewing();

        Artisan::call('convert:path "' . $filePath . '" --output="' . $outputDirectory . '"');

        $boardSessionPathForView = FileUtility::generatePathForViewing($outputDirectory, $fileName);

        new PDFLinkResolver(FileUtility::publicDirectoryForViewing() . FileUtility::changeExtension($fileName));

        return view('user.schedule.index', [
            'schedules' => $scheduleRepository->groupedByDate($dates),
            'boardSessionPathForView' => $boardSessionPathForView,
            'boardSession' => $latestPublishedBoardSession,
            'settings' => $settingRepository->getByNames('name', ['prepared_by', 'noted_by']),
            'dates' => implode('&', $dates),
        ]);
    }
}
