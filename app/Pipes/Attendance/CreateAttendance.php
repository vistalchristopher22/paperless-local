<?php

namespace App\Pipes\Attendance;

use Closure;
use App\Models\SanggunianMember;
use App\Contracts\Pipes\IPipeHandler;
use App\Models\LegislativeAttendance\AttendanceLog;
use App\Repositories\SanggunianMemberRepository;

final class CreateAttendance implements IPipeHandler
{
    public function __construct(private readonly SanggunianMemberRepository $sanggunianMemberRepository)
    {
    }


    public function handle(mixed $payload, Closure $next)
    {
        $sanggunianMembers = $this->sanggunianMemberRepository->get();
        foreach ($sanggunianMembers as $sanggunianMember) {
            AttendanceLog::create([
                'sanggunian_member_id' => $sanggunianMember->id,
                'schedule_id' => $payload['schedule']['id']
            ]);
        }
        return $next($payload);
    }
}
