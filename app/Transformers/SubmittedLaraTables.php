<?php

namespace App\Transformers;

use Carbon\Carbon;
use App\Enums\CommitteeStatus;

class SubmittedLaraTables
{
    public static function laratablesAdditionalColumns()
    {
        return ['lead_committee', 'expanded_committee', 'file_path'];
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

    public static function laratablesCustomAction($committee)
    {
        return view('admin.committee.includes.committee-dashboard-action', compact('committee'))->render();
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
        return $query->where('status', CommitteeStatus::REVIEW->value);
    }
}
