<?php

namespace App\Transformers;

use App\Models\BoardSession;

class BoardSessionLaraTables
{
    public static function laratablesAdditionalColumns()
    {
        return ['file_path', 'schedule_id'];
    }

    public static function laratablesCustomAction(BoardSession $boardSession)
    {
        return view('admin.board-sessions.includes.action', compact('boardSession'))->render();
    }

    public static function laratablesCustomSchedule(BoardSession $boardSession)
    {
        return view('admin.board-sessions.includes.schedule', compact('boardSession'))->render();
    }

    public static function laratablesScheduleRelationQuery()
    {
        return function ($query) {
            $query->with('schedule_information');
        };
    }

    public static function laratablesFileLinkRelationQuery()
    {
        return function ($query) {
            $query->with('file_link');
        };
    }

    public static function laratablesQueryConditions($query)
    {
        if(request()->regularSession !== '*') {
            $query = $query->with(['schedule_information', 'schedule_information.regular_session'])->whereHas('schedule_information.regular_session', function ($q) use ($query) {
                $q->where('id', request()->regularSession);
            });
        }

        return $query;
    }
}
