<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendPasswordResetLinkRequest;
use App\Http\Resources\UserResource;
use App\Http\Service\AuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function hello(): JsonResponse {
        return response()->json([
            'status' => 'hello',
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        Log::info("Register request {email}", ['email'=>$request->email]);
        $this->authService->register($request);
        return response()->json([
            'status' => 'user-created',
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        $token = Auth::attempt($credentials);
        Log::info($credentials);
        Log::info("Login request, token: ");
        Log::info($token);

        if (!$token) {
            return response()->json([
                'status' => 'invalid-credentials',
            ], 401);
        }
        $user = Auth::user();
        Log::info($user);
        return response()->json([
            'user'         => new UserResource($user),
            'access_token' => $token,
        ]);
    }

    public function logout(): Response
    {
        Auth::logout();

        return response()->noContent();
    }

    public function refresh(): JsonResponse
    {
        $token = Auth::refresh();

        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function sendPasswordResetEmail(SendPasswordResetLinkRequest $request): JsonResponse{
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json([
            'status' => __($status),
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password'       => Hash::make($request->input('password')),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json([
            'status' => __($status),
        ]);
    }

    public function resendVerificationEmail() : JsonResponse {
        if (Auth::user()->email_verified_at) {
            return response()->json([
                'status' => 'email-already-verified',
            ]);
        }

        $newuser = User::find(Auth::user()->id);
        $newuser->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'verification-link-sent',
        ]);
    }

    public function verifyEmail(EmailVerificationRequest $request): JsonResponse{
        LOG::info("Verifying email {email}", ['email'=>$request->user()->email]);
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'status' => 'email-already-verified',
            ]);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->json([
            'status' => 'email-verified',
        ]);
    }
}
