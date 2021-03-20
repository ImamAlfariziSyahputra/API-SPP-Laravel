<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  public function login(Request $request)
  {
    $user = User::create($request->all());
    return response()->json($user, 200);
  }
}
