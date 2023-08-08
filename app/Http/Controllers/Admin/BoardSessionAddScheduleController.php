<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pipes\BoardSession\AddSchedule;
use App\Pipes\BoardSession\MoveBoardSessionFileToRootDirectory;
use App\Repositories\BoardSessionRespository;
use App\Repositories\ScheduleRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Pipeline;

final class BoardSessionAddScheduleController extends Controller
{
    public function __construct(private readonly BoardSessionRespository $boardSessionRepository, private readonly ScheduleRepository $scheduleRepository)
    {

    }

    public function __invoke(Request $request): void
    {
        try {
            DB::transaction(function () use ($request) {
                Pipeline::send($request->all())
                    ->through([
                        AddSchedule::class,
                        MoveBoardSessionFileToRootDirectory::class,
                    ])
                    ->then(fn ($data) => $data);
            });
        } catch (Exception $exception) {
            $this->scheduleRepository->deleteSchedule($request->schedule_id);
            Log::info('Add schedule to board session failed' . $exception->getMessage());
        }
    }
}
