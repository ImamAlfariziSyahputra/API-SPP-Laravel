<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  public function register(Request $request)
  {

    if ($request->role == null) {
      $request->validate([
        'name' => ['required'],
        'email' => ['required','email', 'unique:user'],
        'password' => ['required','min:8','confirmed'],
      ]);

      User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'student',
      ]);

      return response()->json(['message' => 'Success'], 200);
    } else {
      $request->validate([
        'name' => ['required'],
        'email' => ['required','email', 'unique:user'],
        'password' => ['required','min:8','confirmed'],
        'role' => ['required'],
      ]);

      User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
      ]);

      return response()->json(['message' => 'Success'], 200);
    }
  }
  
}
