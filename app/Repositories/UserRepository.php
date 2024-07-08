<?php
namespace App\Repositories;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Resources\AuthResource;

class UserRepository
{
    public function register(RegisterRequest $request) :array|\Exception
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated());
            $user->account()->create(['balance' => config('constants.opening_account_balance')]);
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
            return [ 'token' => $token,  'user' => $user ];
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error registering: ' . $e->getMessage());
            throw $e;
        }
    }

    public function login(LoginRequest $request) :array|\Exception
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw new \Exception('Invalid credentials', 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return  ['token' => $token, 'user' => $user];
    }

    public function logout(Request $request):void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
