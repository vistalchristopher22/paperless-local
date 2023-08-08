<?php

namespace App\Services;

use App\Contracts\Services\IUploadService;
use Illuminate\Support\Facades\Request;

final class SanggunianMemberService extends AccountService
{
    public function isUserWantToChangeProfilePicture(Request $request, IUploadService $iUploadService)
    {
        if ($request->has('image')) {
            $fileName = $iUploadService->handle($request->file('image'));

            $request->merge(['profile_picture' => $fileName]);
        }

        return $request->all();
    }
}
