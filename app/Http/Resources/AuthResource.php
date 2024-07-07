<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray($request)
    {
        return (object) [
            'message' => $this->message,
            'token' => $this->token,
            'user' => $this->user,
        ];
    }

    public  function boot()
    {
        JsonResource::withoutWrapping();
    }
}
