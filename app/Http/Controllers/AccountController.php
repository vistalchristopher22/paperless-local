<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountInformationRequest;
use App\Pipes\User\ChangePassword;
use App\Pipes\User\ProfilePicture;
use App\Pipes\User\UpdateUser;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

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
     * > The `update` function takes an `UpdateAccountInformationRequest` object, sends it through a
     * pipeline of classes, and then returns a response
     *
     * @param UpdateAccountInformationRequest request The request object
     * @return The user is being returned.
     */
    public function update(UpdateAccountInformationRequest $request)
    {
        DB::transaction(function () use ($request) {
            Pipeline::send($request->merge(['account' => $this->userRepository->findBy('id', auth()->user()->id)]))
                ->through([
                    ProfilePicture::class,
                    ChangePassword::class,
                    UpdateUser::class,
                ])->then(fn ($data) => $data);
        });

        return back()->with('success', 'Success! account details have been updated.');
    }
}
