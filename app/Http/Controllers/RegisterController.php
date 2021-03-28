<?php

namespace App\Http\Controllers;

use App\Siswa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  public function register(Request $request)
  {
    // return $request;
    if ($request->role == null) { // Buat Register
      // return $request;
      $request->validate([
        'name' => ['required'],
        'email' => ['required','email', 'unique:user'],
        'password' => ['required','min:8','confirmed'],

        'id' => ['required','unique:siswa'], // ID MAKSUDNYA NISN SISWA
        'nis' => ['required','unique:siswa'],
        'id_kelas' => ['required'],
        'alamat' => ['required'],
        'no_telp' => ['required'],
      ]);

      User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'student',
      ]);

      Siswa::create([
        'id' => $request->id,
        'nis' => $request->nis,
        'nama' => $request->name,
        'id_kelas' => $request->id_kelas,
        'alamat' => $request->alamat,
        'no_telp' => $request->no_telp,
      ]);

      return response()->json(['message' => 'Success'], 200);
    } else { // BUAT CRUD ACCOUNT ADMIN
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
