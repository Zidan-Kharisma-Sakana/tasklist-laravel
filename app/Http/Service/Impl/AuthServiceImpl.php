<?php

namespace App\Http\Service\Impl;

use App\Http\Service\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl implements AuthService{
    public function register(RegisterRequest $req){
        $user = User::create([
            'name'     => $req->input('name'),
            'email'    =>  $req->input('email'),
            'password' => Hash::make($req->input('password')),
        ]);
        event(new Registered($user));
    }
}
