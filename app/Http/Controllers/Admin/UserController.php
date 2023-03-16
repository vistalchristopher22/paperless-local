<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserTypes;
use App\Enums\UserStatus;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\UploadImageService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\DivisionRepository;

final class UserController extends Controller
{
    private $divisionRepository;


    public function __construct(private UserRepository $userRepository, private UserService $userService)
    {
        $this->divisionRepository = app()->make(DivisionRepository::class);
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
            'divisions' => $this->divisionRepository->get()
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
            'divisions' => $this->divisionRepository->get()
        ]);
    }


   /**
    * > The store function is used to store a new user in the database
    *
    * @param UserStoreRequest request The request object.
    *
    * @return The user is being returned to the previous page with a success message.
    */
    public function store(UserStoreRequest $request)
    {
        $data = $this->userService->isUserWantToChangeProfilePicture($request, new UploadImageService());
        $this->userRepository->store($data);
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
            'divisions' => $this->divisionRepository->get()
        ]);
    }


    /**
     * If the user wants to change their profile picture, then upload the image and save the path to
     * the database. If the user wants to change their password, then hash the password and save it to
     * the database
     *
     * @param UserUpdateRequest request The request object
     * @param User account The account model instance.
     *
     * @return The user is being returned.
     */
    public function update(UserUpdateRequest $request, User $account)
    {
        $data = $this->userService->isUserWantToChangeProfilePicture($request, new UploadImageService());
        $data = $this->userService->isUserWantToChangePassword($data);
        $this->userRepository->update($account, $data);

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
