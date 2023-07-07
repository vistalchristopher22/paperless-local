<?php

namespace App\Pipes\BoardSession;

use App\Contracts\Pipes\IPipeHandler;
use App\Enums\BoardSessionStatus;
use Closure;

final class DatatablesWrapper implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        $payload = datatables()->of($payload)
            ->addIndexColumn()
            ->editColumn('created_at', function ($boardSession) {
                return $boardSession->created_at->format('F d, Y h:i A');
            })
            ->addColumn('action', function ($boardSession) {
                $editButton = '<a href="' . route('board-sessions.edit', $boardSession->id) . '" class="dropdown-item text-primary text-center fw-medium cursor-pointer">Edit</a>';
                $showButton = '<a href="' . route('board-sessions.show', $boardSession->id) . '" class="dropdown-item text-primary text-center fw-medium cursor-pointer">View</a>';
                $lockedButton = '<a data-id=' . $boardSession->id . ' class="dropdown-item text-primary btn-lock-session text-center fw-medium cursor-pointer">Lock</a>';
                $unlockedButton = '<a data-id=' . $boardSession->id . ' class="dropdown-item text-primary btn-unlock-session text-center fw-medium cursor-pointer"> Unlock</a>';
                $deleteButton = '<a data-id=' . $boardSession->id . ' class="dropdown-item text-danger btn-delete-session text-center fw-medium cursor-pointer"> Delete</a>';
                if ($boardSession->status == BoardSessionStatus::LOCKED->value) {
                    return '<div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownAction" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownAction" style="">
                                <li>' . $showButton . '</li>
                                <li class="dropdown-divider"></li>
                                <li>' . $unlockedButton . ' </li>
                            </ul>
                        </div>';
                } else {
                    return '<div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownAction" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownAction" style="">
                                <li>' . $editButton . '</li>
                                <li class="dropdown-divider"></li>
                                <li>' . $showButton . ' </li>
                                <li class="dropdown-divider"></li>
                                <li>' . $lockedButton . ' </li>
                                <li class="dropdown-divider"></li>
                                <li>' . $deleteButton . ' </li>
                            </ul>
                        </div>';
                }
            })
            ->addColumn('status', function ($boardSession) {
                if ($boardSession->status == BoardSessionStatus::LOCKED->value) {
                    return '<span class="badge bg-danger">' . $boardSession->status . '</span>';
                } else {
                    return '<span class="badge bg-primary">' . $boardSession->status . '</span>';
                }
            })
            ->addColumn('published', function ($boardSession) {
                if ($boardSession->is_published == 1) {
                    return '<span class="badge bg-success text-uppercase">Yes</span>';
                } else {
                    return '<span class="badge bg-primary text-uppercase">No</span>';
                }
            })
            ->rawColumns(['action', 'status', 'published'])
            ->make(true);

        return $next($payload);
    }
}
