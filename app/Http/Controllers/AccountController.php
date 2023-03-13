<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
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
     * It updates the user's account details.
     *
     * @param Request request The request object
     * @return The user is being returned to the previous page with a success message.
     */
    public function update(Request $request)
    {
        $this->userRepository->update(
            $this->userRepository->findBy('id', auth()->user()->id),
            $this->userService->isUserWantToChangePassword($request->except('_token'))
        );

        return back()->with('success', 'Success! account details have been updated.');
    }
}
