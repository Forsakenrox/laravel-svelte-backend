<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]
        );

        $user = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return ['token' => $user->createToken("API TOKEN")->plainTextToken];
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            $errorMessages = new \Illuminate\Support\MessageBag;
            return $errorMessages->merge([
                'message' => 'wrong credentials',
                'errors' => ['credentials' => 'no valid credentials']
            ]);
        }
        $user = User::where('email', $request->email)->first();
        return ['token' => $user->createToken("API TOKEN")->plainTextToken];
    }
}
