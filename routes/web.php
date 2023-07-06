<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Utilities\CommitteeFileUtility;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\Archive\FileBulkDeleteController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\Archive\FileController;
use App\Http\Controllers\Admin\Archive\FilePreviewController;
use App\Http\Controllers\Admin\Archive\FileShowInExplorerController;
use App\Http\Controllers\Admin\BoardSessionController;
use App\Http\Controllers\Admin\CommitteeFileController;
use App\Http\Controllers\SPMember\SPMCommitteeController;
use App\Http\Controllers\Admin\SanggunianMemberController;
use App\Http\Controllers\Admin\SubmittedCommitteeController;
use App\Http\Controllers\Admin\SanggunianMemberAgendaController;
use App\Http\Controllers\Admin\CommitteeMeetingScheduleController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePrintController;
use App\Http\Controllers\Admin\CommitteeMeetingSchedulePreviewController;

Route::redirect('/', '/login');
Auth::routes();
Route::get('submitted-committee/list', SubmittedCommitteeController::class);
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'features:administrator'], function () {
        Route::post('re-order/agenda', [AgendaController::class, 'reOrder'])->name('agenda.re-order');
        Route::get('sanggunian-member/{member}/agendas/show', SanggunianMemberAgendaController::class)->name('sanggunian-member.agendas.show');

        Route::get('schedule/committees/{dates}/preview', CommitteeMeetingSchedulePreviewController::class)->name('committee-meeting-schedule.preview');
        Route::get('schedule/committees/{dates}/print', CommitteeMeetingSchedulePrintController::class)->name('committee-meeting-schedule.print');
        Route::get('schedule/committees/{dates}', [CommitteeMeetingScheduleController::class, 'show'])->name('committee-meeting-schedule.show');
        Route::post('schedule/committees', [CommitteeMeetingScheduleController::class, 'store'])->name('committee-meeting-schedule.store');

        Route::get('board-sessions/list', [BoardSessionController::class, 'list'])->name('board-sessions.list');
        Route::post('board-sessions/locked/{board_session}', [BoardSessionController::class, 'locked'])->name('board-sessions.locked');
        Route::post('board-sessions/unlocked/{board_session}', [BoardSessionController::class, 'unlocked'])->name('board-sessions.unlocked');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::get('edit-information', [AccountController::class, 'edit'])->name('information.edit');
        Route::put('edit-information', [AccountController::class, 'update'])->name('information.update');

        Route::prefix('file')->group(function () {
            Route::post('archive/show-in-explorer', FileShowInExplorerController::class)->name('file.show-in-explorer');
            Route::post('archive/preview', FilePreviewController::class)->name('file.preview');
            Route::delete('archive/delete/bulk', FileBulkDeleteController::class)->name('file.delete.bulk');

            Route::get('archive/list', [FileController::class, 'list'])->name('file.list');
            Route::post('archive/details', [FileController::class, 'show'])->name('file.show');
            Route::post('archive/rename', [FileController::class, 'update'])->name('file.update');
            Route::post('archive/upload', [FileController::class, 'store'])->name('file.store');
            Route::delete('archive/delete', [FileController::class, 'destroy'])->name('file.delete');
        });

        Route::post('/admin/files/filter/type', [FileController::class, 'getFileByTypes']);

        Route::resources([
            'account' => UserController::class,
            'account-access-control' => UserAccessController::class,
            'sanggunian-members' => SanggunianMemberController::class,
            'agendas' => AgendaController::class,
            'division' => DivisionController::class,
            'committee' => CommitteeController::class,
            'schedules' => ScheduleController::class,
            'committee-file' => CommitteeFileController::class,
            'board-sessions' => BoardSessionController::class,
            'files' => FileController::class,
        ]);
    });
});

// SB MEMBER
Route::group(['prefix' => 'sb-member', 'middleware' => ['auth', 'features:sb-member']], function () {
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
    // Route::get('sbm-committees', [SPMCommitteeController::class, 'index'])->name('sbm.committee.index');
});

Route::get('show-attachment/{url}/{location}', function (string $file, string $location) {
    $location = str_replace('-', '/', $location);
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $path = $location . '/' . $file;
    $path = CommitteeFileUtility::fixTemporaryForwardSlashSeparator($path);
    $outputDirectory = CommitteeFileUtility::publicDirectoryForViewing();
    if (in_array($extension, CommitteeFileUtility::CONVERTIBLE_FILE_EXTENSIONS)) {
        Artisan::call('convert:path "' . $path . '" --output="' . $outputDirectory . '"');
    } else {
        $path = Str::after($path, 'storage');
        $path = CommitteeFileUtility::correctDirectorySeparator(base_path() . '/storage' . $path);
        copy($path, $outputDirectory . $file);
    }

    $pathForView = CommitteeFileUtility::generatePathForViewing($outputDirectory, $file);
    $basePath = base_path();
    $escaped_path = escapeshellarg(CommitteeFileUtility::publicDirectoryForViewing() . CommitteeFileUtility::changeExtension($file));
    shell_exec("python.exe $basePath\\reader.py -f $escaped_path");

    return view('testing', [
        'filePathForView' => $pathForView,
    ]);
})->name('show-attachment');
