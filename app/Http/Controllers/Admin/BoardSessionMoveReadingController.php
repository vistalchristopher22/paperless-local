<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BoardSessionDocumentService;
use Illuminate\Http\Request;

final class BoardSessionMoveReadingController extends Controller
{
    public function __construct(private readonly BoardSessionDocumentService $boardSessionDocumentService)
    {
    }

    public function __invoke(Request $request)
    {
    }
}
