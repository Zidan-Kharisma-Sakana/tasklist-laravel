<?php

namespace App\Http\Service\Impl;

use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Service\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService{
    public function updateUser(UpdateUserRequest $request): User{
        $user = $request->user();

        $user->fill([
            'name'  =>  $request->input("name"),
            'email' =>  $request->input("email"),
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();
        return $user;
    }
    public function changePassword(ChangePasswordRequest $request){
        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->input("password")),
        ]);
    }
}
