<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Siswa;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
      return User::all();
    }

    public function authUser()
    {
      return Auth::user();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      $user = User::create($request->all());
      return response()->json($user, 200);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
      $user = User::findOrFail($id);

      if ($request->password == null && $request->new_password == null){ // CUMA GANTI NAMA DAN ROLE
        $this->validate($request, [
          'name' => ['required'],
          // 'email' => ['required','email', 'unique:user'],
          'role' => ['required'],
          // 'password' => ['required','min:8'],
          // 'new_password' => ['confirmed','min:8','different:password'],
        ]);

        if($user->role == 'student') {
          $siswa = Siswa::where('nama', $request->old_name)
                          ->update(['nama' => $request->name]);
          // return $siswa;
        }

        $user->fill([
          'name' => $request->name,
          // 'email' => $request->email,
          'role' => $request->role,
          'password' => Hash::make($request->new_password),
        ])->save();
    
        return response()->json(['message' => 'Success'], 200);
      } else { // GANTI SEMUA DATA AUTH
        $this->validate($request, [
          'name' => ['required'],
          // 'email' => ['required','email', 'unique:user'],
          'role' => ['required'],
          'password' => ['required','min:8'],
          'new_password' => ['confirmed','min:8','different:password'],
        ]);

        if($user->role == 'student') {
          $siswa = Siswa::where('nama', $request->name)
                        ->update(['nama' => $request->name]);
        }
        // --------------BUAT CHANGE PASSWORD USER------------------------------
        // if (!Hash::check($request['old_password'], Auth::user()->password)) {
        //   return response()->json(['error' => ['The old password does not match our records.'] ]);
        // }
        // $hashed_new_password = Hash::make($request->password);
        // return $hashed_new_password;
        if (Hash::check($request->password, $user->password)) { 
          $user->fill([
            'name' => $request->name,
            // 'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->new_password),
          ])->save();
      
          return response()->json(['message' => 'Success'], 200);
        } else {
          return response()->json(
            ['errors' => ['old_password' => 'The old password does not match our records.']], 422
          );
        }
      }
    }

    public function destroy($id)
    {
      $user = User::where('id', $id)->delete();

      return response($user, 200);
    }
}
