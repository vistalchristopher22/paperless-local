<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\UploadImageService;
use App\Services\UserService;
use Illuminate\Http\Request;

final class AccountController extends Controller
{
    /**
     * > The constructor function is used to inject dependencies into the class
     */
    public function __construct(private UserRepository $userRepository, private UserService $userService)
    {
    }

    /**
     * It returns a view called `auth.settings.edit` and passes in the `account` variable
     *
     * @return The view auth.settings.edit is being returned.
     */
    public function edit()
    {
        return view('auth.settings.edit', [
            'account' => auth()->user(),
        ]);
    }



    /**
     * > The user wants to update their profile picture and/or password
     *
     * @param Request request The request object
     */
    public function update(Request $request)
    {
        $data = $this->userService->isUserWantToChangeProfilePicture($request, new UploadImageService());
        $data = $this->userService->isUserWantToChangePassword($request->except(['_token', 'image']));
        $this->userRepository->update($this->userRepository->findBy('id', auth()->user()->id), $data);
        return back()->with('success', 'Success! account details have been updated.');
    }
}
