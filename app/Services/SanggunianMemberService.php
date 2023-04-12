<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;
use App\Contracts\Services\IUploadService;
use App\Repositories\SanggunianMemberRepository;

final class SanggunianMemberService extends AccountService
{
    public function __construct(private SanggunianMemberRepository $sanggunianMemberRepository)
    {
    }


   /**
    * It checks if the request has an image, if it does, it uploads it and then merges the file name
    * into the request
    *
    * @param Request request The request object
    * @param IUploadService iUploadService This is the service that will handle the upload.
    *
    * @return The request object with the profile_picture key added to it.
    */
    public function isUserWantToChangeProfilePicture(Request $request, IUploadService $iUploadService)
    {
        if ($request->has('image')) {
            $fileName = $iUploadService->handle($request->file('image'));

            $request->merge(['profile_picture' => $fileName]);
        }

        return $request->all();
    }
}
