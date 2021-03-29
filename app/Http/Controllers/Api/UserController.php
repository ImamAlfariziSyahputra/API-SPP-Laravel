<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Siswa;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
      $user = User::all();
      return response()->json($user, 200);
    }

    public function authUser()
    {
      $user= Auth::user();
      return response()->json($user, 200);
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
        // return [$hashed_new_password, $request->password];
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

    public function count()
    {
      $user = User::where([
        'is_online' => 1,
      ])->count();

      return response($user, 200);
    }

    public function postImage(Request $request)
    {
      // return $request;
      // $file = $request->file('file');
      // $file = $request->file;

      // if ($request->hasFile('file')) {
      //   return response()->json(['Success' => 'From HasFile'], 200);
      // }
      // return response()->json(['image' => $file], 200);

      // $filename = $request->file('file')->getClientOriginalName();
      // $filename = $request->file->getClientOriginalName();

      // $avatar = $request->file('file');
      if($request->hasFile('file') && request('file') != '') {

        $this->validate($request,[
          'file'=>'required|mimes:jpeg,jpg,png'
        ]);

        $avatar = $request->file('file');

        // $oldImage = public_path('storage/'.$request->image);;

        // if(File::exists($oldImage)){
        //     unlink($oldImage);
        // }

        // $avatar->store('file');
        // $image = $avatar->move('avatar', $image);

        // $user = User::where('id', Auth::user()->id)->first();

        // return response()->json(['Old Image' => $user], 200);
        // if($user->image) {
        //   $oldAvatar = public_path('storage/avatar/'. $user->image);

        //   if(Storage::exists($oldAvatar)){
        //     unlink($oldAvatar);
        //   }
        // }
        

        $ext = $avatar->getClientOriginalExtension();
        $thumbnailName = "avatar".Date('YMdhis').'.'.$ext;
        // $path = $avatar->store('avatar', 'public');
        $avatar->move('avatar', $thumbnailName);

        // $avatar->store('avatar', 'public'); 
        // Storage::disk('public')->url('avatar/' . $thumbnailName);

        // return response()->json(['request' => $thumbnailName], 200);

        $user = User::where('id', Auth::user()->id)->update([
          'image'=> $thumbnailName
        ]);

        return response()->json(['request' => $user], 200);
      }


    }
}
