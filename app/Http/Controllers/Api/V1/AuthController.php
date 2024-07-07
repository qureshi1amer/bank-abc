<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated());
            $user->account()->create(['balance' => 0.0]);
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();

            return new AuthResource((object) ['message' => 'Registration successful','token' => $token, 'user' => $user]);
        }
        catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error registering: ' . $e->getMessage());
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()],
                500
            );
        }
    }


    public function login(LoginRequest $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return new AuthResource( (object) ['message' => 'Login successful','token' => $token, 'user' => $user]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
