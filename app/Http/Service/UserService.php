<?php

namespace App\Http\Service;

use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

interface UserService
{
    public function updateUser(UpdateUserRequest $request) : User;
    public function changePassword(ChangePasswordRequest $request);
}
