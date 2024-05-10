<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Schedule;
use App\Http\Controllers\Controller;

final class BoardSessionPublishPreviewController extends Controller
{
    public function __invoke(string $date)
    {
        $date = Carbon::parse($date);
        $schedule = Schedule::with(['order_of_business_information' => [
            'file_link'
        ]])
            ->whereYear('date_and_time', $date->year)
            ->whereMonth('date_and_time', $date->month)
            ->whereDay('date_and_time', $date->day)
            ->first();


        $session = $schedule->order_of_business_information;


        if ($session) {
            $orderBusinessView = str_replace(pathinfo(basename($session->file_path), PATHINFO_EXTENSION), 'pdf', $session->file_path);
            return inertia('OrderBusiness', [
                'file' => basename($orderBusinessView),
                'id' => $session->id,
                'watermarkSchedule' => $schedule->reference_session . ' - ' . $schedule->type,
            ]);
        }

        return view('errors.attachment-not-found');
    }
}
