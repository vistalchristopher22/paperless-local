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
                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                        <li><a href="#" class="dropdown-item">Show File</a></li>
                    </ul>
                </div>
                ';
            } else {
                return '
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                        <li><a href="#" class="dropdown-item">Show File</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="' . route('user.committee.edit', $row->id) . '" class="dropdown-item">Edit Committee</a></li>
                    </ul>
                </div>
                ';
            }
        })->rawColumns(['actions'])->make(true);

        return $next($payload);
    }
}
