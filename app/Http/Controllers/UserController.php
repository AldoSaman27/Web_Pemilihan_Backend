<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Validator;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware("auth:sanctum", ["except" => ["login", "register"]]);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:5",
            "level" => "required|string|in:Admin 1,Admin 2",
        ]);

        if ($validator->fails()) return response()->json([
            "message" => "Invalid field",
            "errors" => $validator->errors(),
        ], 422);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "level" => $request->level,
        ]);
        $accessToken = $user->createToken("accessToken")->plainTextToken;

        if ($user) return response()->json([
            "message" => "Register success",
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "level" => $user->level,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
                "accessToken" => $accessToken,
            ],
        ]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "password" => "required|string|min:5",
        ]);

        if ($validator->fails()) return response()->json([
            "message" => "Invalid field",
            "errors" => $validator->errors(),
        ], 422);

        if (!Auth::attempt($request->only("name", "password"))) return response()->json(["message" => "Username or Password incorrect!"]);

        $user = User::where("name", $request->name)->first();
        $accessToken = $user->createToken("accessToken")->plainTextToken;

        if ($user) return response()->json([
            "message" => "Login success",
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "level" => $user->level,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
                "accessToken" => $accessToken,
            ],
        ]);
    }

    public function logout(Request $request) {
        $accessToken = $request->user()->currentAccessToken("accessToken")->delete();
        if ($accessToken) return response()->json(["message" => "Logout success"]);
    }

    public function statusToken() {
        return response()->json(["statusToken" => true]);
    }
}