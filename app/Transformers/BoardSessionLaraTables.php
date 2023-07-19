<?php

namespace App\Transformers;


use App\Models\BoardSession;

class BoardSessionLaraTables
{

    public static function laratablesAdditionalColumns()
    {
        return ['file_path', 'unassigned_business_file_path', 'schedule_id'];
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
}
