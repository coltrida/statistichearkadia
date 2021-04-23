<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where([
            ['email', $request->email]
        ])->first();

        /*if (Hash::check($request->password, $user->password)) {
            return $user;
        }*/
        return $user;
    }

    public function register(Request $request)
    {

    }
}
