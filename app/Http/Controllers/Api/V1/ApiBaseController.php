<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ApiBaseController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

}
