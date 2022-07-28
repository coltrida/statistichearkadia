<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function compact;
use function redirect;
use function view;

class UserController extends Controller
{
    public function index()
    {
        $user = User::OrderBy('name')->get();
        return UserResource::collection($user);
    }

    public function eseguiassociaoperatoreore(Request $request)
    {
        $user = User::find($request->operatore);
        $user->oresettimanali = $request->ore;
        $user->save();
        return $user;
    }

    public function logs()
    {
        $logs = \Spatie\Activitylog\Models\Activity::latest()->take(200)->get();
        return LogResource::collection($logs);
    }

    public function salvaoperatore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    }
}
