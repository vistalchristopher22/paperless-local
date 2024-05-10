<?php

namespace App\Repositories;

use App\Utilities\FileUtility;
use App\Models\CommitteeFileLink;

final class CommitteeFileLinkRepository extends BaseRepository
{
    public function __construct(CommitteeFileLink $model)
    {
        parent::__construct($model);
    }

    public function getPublicLink(string $fileName): CommitteeFileLink
    {
        return CommitteeFileLink::where('public_path', 'like', '%' . FileUtility::changeExtension($fileName) . '%')
            ->first();
    }

    public function getByUUID(string $uuid): CommitteeFileLink|null
    {
        return $this->model->with(['committee:id,name,display_index,lead_committee,expanded_committee,expanded_committee_2,expanded_committee_3,schedule_id', 'committee.schedule_information'])
            ->where('uuid', $uuid)
            ->first();
    }
}
