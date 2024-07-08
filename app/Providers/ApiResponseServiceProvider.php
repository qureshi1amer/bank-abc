<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('api', function ($data = null, $message = 'Success', $status = 200) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ], $status);
        });
    }
}
