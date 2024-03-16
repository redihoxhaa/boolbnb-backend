<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        $user = User::find($data['user_id']);

        return response()->json($user);
    }

    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }
}
