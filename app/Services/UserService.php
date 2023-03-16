<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Contracts\Services\IUploadService;

final class UserService extends AccountService
{
    public function __construct(private UserRepository $userRepository)
    {
    }


    /**
     * If the request has an image, upload it and merge the file name into the request
     *
     * @param Request request The request object
     * @param IUploadService uploadService This is the service that will handle the upload.
     *
     * @return The request object with the profile_picture key added to it.
     */
    public function isUserWantToChangeProfilePicture(Request $request, IUploadService $uploadService)
    {
        if ($request->has('image')) {
            $fileName = $uploadService->handle($request->file('image'));
            $request->merge(['profile_picture' => $fileName]);
        }

        return $request->all();
    }
}
