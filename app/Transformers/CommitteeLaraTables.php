<?php

namespace App\Transformers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class CommitteeLaraTables
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
        return view('admin.committee.includes.action', compact('committee'))->render();
    }

    /**
     * Eager load media items of the role for displaying in the datatables.
     *
     * @return callable
     */
    public static function laratablesLeadCommitteeRelationQuery()
    {
        return function ($query) {
            $query->with('lead_committee_information');
        };
    }

    /**
     * Eager load media items of the role for displaying in the datatables.
     *
     * @return callable
     */
    public static function laratablesExpandedCommitteeRelationQuery()
    {
        return function ($query) {
            $query->with('expanded_committee_information');
        };
    }
}
