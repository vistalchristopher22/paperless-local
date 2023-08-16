<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountInformationRequest;
use App\Pipes\User\ChangePassword;
use App\Pipes\User\ProfilePicture;
use App\Pipes\User\UpdateUser;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

final class AccountController extends Controller
{
    public function edit()
    {
        return view('auth.settings.edit', [
            'account' => auth()->user(),
        ]);
    }

    public function update(UpdateAccountInformationRequest $request, UserRepository $userRepository)
    {
        DB::transaction(function () use ($userRepository, $request) {
            Pipeline::send($request->merge(['account' => $userRepository->findBy('id', auth()->user()->id)]))
                ->through([
                    ProfilePicture::class,
                    ChangePassword::class,
                    UpdateUser::class,
                ])->then(fn($data) => $data);
        });

        return back()->with('success', 'Success! account details have been updated.');
    }
}
