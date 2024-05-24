<?php

namespace App\Pipes\Committee;

use App\Contracts\Pipes\IPipeHandler;
use App\Models\CommitteeInvitedGuest;
use Closure;
use Illuminate\Support\Facades\DB;

class AddInvitedGuests implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        return DB::transaction(function () use ($payload, $next) {
            $committee = $payload;
            $guests = [];

            if (json_validate(request()->guests) === true) {
                $guests = json_decode(request()->guests, true);
            }

            $submittedGuest = array_filter($guests, 'array_filter');

            $payload->committee_invited_guests()->delete();

            foreach ($submittedGuest as $guest) {
                CommitteeInvitedGuest::create([
                    'committee_id' => $payload->id,
                    'fullname' => str()->upper($guest['fullname']),
                ]);
            }

            if (count($submittedGuest) > 0) {
                $payload->update([
                    'invited_guests' => 1,
                ]);
            }

            return $next($committee);
        });
    }
}
