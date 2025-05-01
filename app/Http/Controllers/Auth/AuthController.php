<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function Signup(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:4'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ]);
        }

        $validated = $validator->validate();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            'message' => 'register berhasil',
            'user' => $user,
            'token' => $user->createToken('auth')->plainTextToken
        ]);
    }

    public function Login(Request $request) {
        $validated  = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user  = User::where('email', $validated['email'])->first();
        if ($user && (Hash::check($validated['password'], $user->password) || $validated['password'] === $user->password)) {
            // $user->last_login_at = now();
            $user->save();
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json([
            'status' => 'invalid',
            'message' => 'Wrong username or password'
        ], 401);
    }

    public function Logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
