<?php

namespace App\Pipes\Committee\User;

use App\Contracts\Pipes\IPipeHandler;
use Closure;
use Yajra\DataTables\Facades\DataTables;

final class DataTablesWrapper implements IPipeHandler
{
    public function __construct()
    {
    }

    public function handle(mixed $payload, Closure $next)
    {
        return DataTables::of($payload)->addColumn('submitted_by', function ($row) {
            return $row?->submitted?->first_name . ' ' . $row?->submitted?->last_name;
        })->addColumn('actions', function ($row) {
            if ($row->submitted_by != auth()->user()->id) {
                return '
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                        <li><a href="#" class="dropdown-item">Show File</a></li>
                    </ul>
                </div>
                ';
            } else {
                return '
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                        <li><a href="#" class="dropdown-item">Show File</a></li>
                        <li><a href="' . route('user.committee.edit', $row->id) . '" class="dropdown-item">Edit Committee</a></li>
                    </ul>
                </div>
                ';
            }
        })->rawColumns(['actions'])->make(true);

        return $next($payload);
    }
}
