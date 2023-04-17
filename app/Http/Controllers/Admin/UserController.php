<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserTypes;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use App\Pipes\User\StoreUser;
use App\Services\UserService;
use App\Pipes\User\UpdateUser;
use App\Pipes\User\ChangePassword;
use App\Pipes\User\ProfilePicture;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Repositories\UserRepository;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\DivisionRepository;
use Illuminate\Support\Facades\Pipeline;

final class UserController extends Controller
{
    private $divisionRepository;


    public function __construct(private UserRepository $userRepository, private UserService $userService)
    {
        $this->middleware('verify.user')->only('destroy');
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
            'users' => $this->userRepository->getWithDivision(),
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
     * > The `store` function takes a `UserStoreRequest` object, sends it through a pipeline of
     * classes, and then returns the data
     *
     * @param UserStoreRequest request The request object
     *
     * @return The user is being returned.
     */
    public function store(StoreRequest $request)
    {
        Pipeline::send($request)
            ->through([
                ProfilePicture::class,
                StoreUser::class,
            ])->then(fn ($data) => $data);


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
     * > The `update` function takes a `UserUpdateRequest` and a `User` model, and then sends the
     * request through a pipeline of classes, and then returns the data
     *
     * @param UserUpdateRequest request The request object
     * @param User account The account model
     *
     * @return The user is being returned.
     */
    public function update(UpdateRequest $request, User $account)
    {
        Pipeline::send($request->merge(['account' => $account]))
            ->through([
                ProfilePicture::class,
                ChangePassword::class,
                UpdateUser::class,
            ])->then(fn ($data) => $data);

        return back()->with('success', 'Success! account details have been updated.');
    }



    /**
     * Delete a user account.
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param \App\Models\User $account The user account to delete.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response indicating whether the operation was successful or not.
     */
    public function destroy(User $account)
    {
        $this->userRepository->delete($account);
        return response()->json(['success' => true, 'message' => 'Account deleted successfully, this page will automatically refresh after 5 seconds to apply the changes.']);
    }
}
