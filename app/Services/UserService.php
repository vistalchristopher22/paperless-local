<?php

namespace App\Services;

use App\Contracts\Services\IUploadImageService;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

final class UserService extends AccountService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * If the request has an image, then upload the image and merge the file name into the request
     *
     * @param Request request The request object
     * @param IUploadImageService uploadService This is the service that will handle the image upload.
     *
     * @return The request object with the profile_picture key added to it.
     */
    public function isUserWantToChangeProfilePicture(Request $request, IUploadImageService $uploadService)
    {
        if ($request->has('image')) {
            $fileName = $uploadService->handle($request->file('image'));
            $request->merge(['profile_picture' => $fileName]);
        }

        return $request->all();
    }
}
