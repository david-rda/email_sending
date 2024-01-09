<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\AuthRequest;
use Auth;

class AuthController extends Controller
{
    public function signin(AuthRequest $request) {
        if($request->validated()) {
            $data = [
                "email" => $request->validated()["email"],
                "password" => $request->validated()["password"],
            ];

            if(Auth::attempt($data)) {
                $token = Auth::user()->createToken("TOKEN")->accessToken;

                return response()->json([
                    "user" => Auth::user(),
                    "token" => $token,
                    "success" => "სისტემაში შესვლა განხორციელდა."
                ], 200);
            }else {
                return response()->json([
                    "error" => "სისტემაში შესვლა ვერ განხორციელდა."
                ], 422);
            }
        }else {
            return response()->json([
                "error" => "შეიყვანეთ სწორი მონაცემები."
            ], 422);
        }
    }

    public function signout(Request $request) {
        Auth::logout();

        return response()->json([
            "success" => "სისტემიდან გასვლა განხორციელდა."
        ], 200);
    }
}
