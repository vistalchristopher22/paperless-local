<?php

namespace App\Transformers;

use Carbon\Carbon;

class CommitteeLaraTables
{
    public static function laratablesAdditionalColumns()
    {
        return ['lead_committee', 'expanded_committee', 'expanded_committee_2', 'file_path', 'schedule_id'];
    }

    public static function laratablesCustomLeadCommittee($committee)
    {
        return view('admin.committee.includes.lead_committee', compact('committee'))->render();
    }

    public static function laratablesCreatedAt($committee)
    {
        return Carbon::parse($committee->created_at)->format('F d, Y h:i A');
    }

    public static function laratablesCustomExpandedCommittee($committee)
    {
        return view('admin.committee.includes.expanded_committee', compact('committee'))->render();
    }

    public static function laratablesCustomOtherExpandedCommittee($committee)
    {
        return view('admin.committee.includes.other_expanded_committee', compact('committee'))->render();
    }

    public static function laratablesCustomSchedule($committee)
    {
        return view('admin.committee.includes.schedule', compact('committee'))->render();
    }

    public static function laratablesCustomAction($committee)
    {
        return view('admin.committee.includes.action', compact('committee'))->render();
    }

    public static function laratablesFileLinkRelationQuery()
    {
        return function ($query) {
            $query->with('file_link');
        };
    }

    public static function laratablesScheduleRelationQuery()
    {
        return function ($query) {
            $query->with('schedule_information');
        };
    }

    public static function laratablesOtherExpandedCommitteeRelationQuery()
    {
        return function ($query) {
            $query->with('other_expanded_committee_information');
        };
    }

    public static function laratablesLeadCommitteeRelationQuery()
    {
        return function ($query) {
            $query->with('lead_committee_information');
        };
    }
    public static function laratablesExpandedCommitteeRelationQuery()
    {
        return function ($query) {
            $query->with('expanded_committee_information');
        };
    }

    public static function laratablesQueryConditions($query)
    {
        if (request()->lead !== '*' && request()->expanded !== '*') {
            $query = $query->where('lead_committee', request()->lead)->where('expanded_committee', request()->expanded)->orWhere('expanded_committee_2', request()->expanded);
        } elseif (request()->lead === '*' && request()->expanded !== '*') {
            $query = $query->where('expanded_committee', request()->expanded)->orWhere('expanded_committee_2', request()->expanded);
        } elseif (request()->lead !== '*' && request()->expanded === '*') {
            $query = $query->where('lead_committee', request()->lead);
        }

        if(request()->regularSession !== '*') {
            $query = $query->with(['schedule_information', 'schedule_information.regular_session'])->whereHas('schedule_information.regular_session', function ($q) use ($query) {
                $q->where('id', request()->regularSession);
            });
        }

        if (request()->ids !== '*') {
            return $query->whereIn('id', explode(',', request()->ids));
        }


        return $query->orderBy('created_at', 'DESC');
    }
}
