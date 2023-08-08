<?php

namespace App\Services;

use App\Contracts\Services\IUploadService;
use Illuminate\Http\Request;

final class UserService extends AccountService
{
    public function isUserWantToChangeProfilePicture(Request $request, IUploadService $uploadService): array
    {
        if ($request->has('image')) {
            $fileName = $uploadService->handle($request->file('image'));
            $request->merge(['profile_picture' => $fileName]);
        }

        return $request->all();
    }
}
