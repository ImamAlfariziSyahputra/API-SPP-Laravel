<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
  public function login(Request $request)
  {
    $validate = $request->validate([
      'email' => ['required'],
      'password' => ['required']
    ]);

    if(Auth::attempt($request->only('email', 'password'))) {
      $user = User::where('email', $request->email)->first();

      $user->is_online = 1;
      $user->update();

      return response()->json(["User" => Auth::user()], 200);
    }

    throw ValidationException::withMessages([
      'email' => ['The Provided Credentials are incorrect']
    ]);

    return response()->json(['Message' => "Error"], 200);

  }

  public function logout()
  {
    $email = Auth::user()->email;
    $user = User::where('email', $email)->first();

    $user->is_online = 0;
    $user->update();

    Auth::logout();
    
    return response()->json(["Message" => "Success"], 200);
  }
}
