<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return User::all();
    }

    public function authUser()
    {
      return Auth::user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = User::create($request->all());
      return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = User::findOrFail($id);
      // dd($user);

      if ($request->password == null && $request->new_password == null){
        $this->validate($request, [
          'name' => ['required'],
          // 'email' => ['required','email', 'unique:user'],
          'role' => ['required'],
          // 'password' => ['required','min:8'],
          // 'new_password' => ['confirmed','min:8','different:password'],
        ]);

        $user->fill([
          'name' => $request->name,
          // 'email' => $request->email,
          'role' => $request->role,
          'password' => Hash::make($request->new_password),
        ])->save();
    
        return response()->json(['message' => 'Success'], 200);
      } else {
        $this->validate($request, [
          'name' => ['required'],
          // 'email' => ['required','email', 'unique:user'],
          'role' => ['required'],
          'password' => ['required','min:8'],
          'new_password' => ['confirmed','min:8','different:password'],
        ]);
        // --------------BUAT CHANGE PASSWORD USER------------------------------
        // if (!Hash::check($request['old_password'], Auth::user()->password)) {
        //   return response()->json(['error' => ['The old password does not match our records.'] ]);
        // }
      
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::where('id', $id)->delete();

      return response($user, 200);
    }
}
