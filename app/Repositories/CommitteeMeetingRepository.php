<?php

namespace App\Repositories;

use Illuminate\Support\Arr;

final class CommitteeMeetingRepository extends CommitteeRepository
{
    /**
     * Add a committee meeting to the specified schedule.
     * @param  mixed  $scheduleId  The ID of the schedule to add the committee meeting to
     * @param  array  $data  An array of data for the committee meeting to add
     * @return void
     */
    public function addCommitteeMeetingToSchedule(mixed $scheduleId, array $data = [])
    {
        $committee = $this->model->find($data['id']);
        $committee->schedule_id = $scheduleId;
        $committee->save();

        Arr::has($data, 'order') && $this->reorderCommitteeDisplayIndices($data['order']);
    }

    /**
     * Reorder committee display indices based on the provided data.
     * @param  array  $newOrderedData  An array of committee IDs in their new order
     * @return void
     */
    private function reorderCommitteeDisplayIndices(array $newOrderedData = [])
    {
        collect($newOrderedData)->each(function ($committeeIds) {
            collect($committeeIds)->each(fn ($committeeId, $index) => $this->model->find($committeeId)->update(['display_index' => $index + 1]));
        });
    }
}
