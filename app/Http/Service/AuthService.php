<?php

namespace App\Http\Service;

use App\Http\Requests\Auth\RegisterRequest;

interface AuthService
{
    public function register(RegisterRequest $request);
}
