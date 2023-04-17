<?php

namespace App\Pipes\BoardSession;

use Closure;
use App\Enums\BoardSessionStatus;
use App\Contracts\Pipes\IPipeHandler;

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
                $editButton = '<a href="' . route('board-sessions.edit', $boardSession->id) . '" class="btn btn-sm btn-success text-white shadow"><i class="fas fa-pen"></i></a>';
                $showButton = '<a href="' . route('board-sessions.show', $boardSession->id) . '" class="btn btn-sm btn-info text-white shadow"><i class="fas fa-eye"></i></a>';
                $lockedButton = '<button data-id=' . $boardSession->id . ' class="btn btn-sm btn-warning text-dark shadow btn-lock-session"><i class="fas fa-lock"></i></button>';
                $unlockedButton = '<button data-id=' . $boardSession->id . ' class="btn btn-sm btn-primary text-white shadow btn-unlock-session"><i class="fas fa-unlock"></i></button>';
                $deleteButton = '<button data-id=' . $boardSession->id . ' class="btn btn-sm btn-danger text-white shadow btn-delete-session"><i class="fas fa-trash"></i></button>';
                if ($boardSession->status == BoardSessionStatus::LOCKED->value) {
                    return $showButton . ' ' . $unlockedButton;
                } else {
                    return $editButton . ' ' . $showButton . ' ' . $lockedButton . ' ' . $deleteButton;
                }
            })
            ->addColumn('status', function ($boardSession) {
                // add span badge for status
                if ($boardSession->status == BoardSessionStatus::LOCKED->value) {
                    return '<span class="badge bg-danger">' . $boardSession->status . '</span>';
                } else {
                    return '<span class="badge bg-primary">' . $boardSession->status . '</span>';
                }
                return $boardSession->status;
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
