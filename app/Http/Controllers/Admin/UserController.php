<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;

final class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository, private UserService $userService)
    {
    }

    /**
     * It returns a view called `admin.account.index` and passes in a variable called `users` which is
     * the result of the `get()` function on the `userRepository` object
     *
     * @return A view with the users from the userRepository
     */
    public function index()
    {
        return view('admin.account.index', [
            'users' => $this->userRepository->get(),
        ]);
    }

    /**
     * It returns a view called `admin.account.create` with two variables: `types` and `status`
     *
     * @return A view with the types and status
     */
    public function create()
    {
        return view('admin.account.create', [
            'types' => UserTypes::cases(),
            'status' => UserStatus::cases(),
        ]);
    }

    /**
     * The `store` function takes a `UserStoreRequest` object as a parameter, and then calls the
     * `store` function on the `userRepository` object, passing in the `->all()` array
     *
     * @param UserStoreRequest request The request object.
     */
    public function store(UserStoreRequest $request)
    {
        $this->userRepository->store($request->all());

        return back()->with('success', 'Success! User account created.');
    }

    /**
     * It returns a view with the account and the types and status.
     *
     * @param User account The model instance that will be passed to the view.
     * @return A view with the account and the types and status
     */
    public function edit(User $account)
    {
        return view('admin.account.edit', compact('account'))->with([
            'types' => UserTypes::cases(),
            'status' => UserStatus::cases(),
        ]);
    }

    /**
     * The `update` function takes a `UserUpdateRequest` and a `User` model, and then updates the
     * `User` model with the `UserService`'s `isUserWantToChangePassword` function
     *
     * @param UserUpdateRequest request The request object.
     * @param User account The account model instance.
     */
    public function update(UserUpdateRequest $request, User $account)
    {
        $this->userRepository->update(
            $account,
            $this->userService->isUserWantToChangePassword($request->except('_token'))
        );

        return back()->with('success', 'Success! account details have been updated.');
    }

    /**
     * > The destroy function is used to delete a user account
     *
     * @param User account The account object that is being deleted.
     * @return The user is being returned.
     */
    public function destroy(User $account)
    {
        $this->userRepository->delete($account);

        return back()->with('success', 'Account successfully deleted.');
    }
}
