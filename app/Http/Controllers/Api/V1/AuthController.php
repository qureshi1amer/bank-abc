<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\Account;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(protected UserRepository $userRepository){}

    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->userRepository->register($request);
            return response()->api($result, __('api.message.registration_successful'));
        } catch (\Exception $e) {
            return response()->api(['error' => $e->getMessage()], 'Registration failed', 500);
        }
    }


    public function login(LoginRequest $request)
    {

        try {
            $result = $this->userRepository->login($request);
            return response()->api($result, __('api.message.login_successful'));
        }
        catch (\Exception $e) {
            return response()->api(['error' => $e->getMessage()], $e->getMessage(), $e->getCode());
        }
    }


    public function logout(Request $request)
    {
        try {
            $this->userRepository->logout($request);
            return response()->api(null, __('api.message.logout_successful'));
        }
        catch (\Exception $e) {
            return response()->api(['error' => $e->getMessage()], __('api.message.logout_failed'), 500);
        }
    }
}
