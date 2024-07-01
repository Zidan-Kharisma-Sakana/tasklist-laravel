<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller {
    private UserService $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function currentUser(Request $request){
        return new UserResource($request->user());
    }

    public function update(UpdateUserRequest $request): UserResource{
        return new UserResource($this->userService->updateUser($request));
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse{
        $this->userService->changePassword($request);
        return response()->json([
            'status' => 'password-changed',
        ]);
    }
}
