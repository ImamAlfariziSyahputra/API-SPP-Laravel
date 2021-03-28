<?php

namespace App\Http\Controllers\Api;

use App\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    
    public function index()
    {
      // return Siswa::all();
      $siswa = DB::table('siswa')
            ->join('kelas', 'kelas.id', '=', 'siswa.id_kelas')
            // ->join("spp", "spp.id", "=", "siswa.id_spp")
            ->select('siswa.*', 'kelas.nama_kelas as nama_kelas')
            ->get();

      // dd($siswa);

      return response()->json($siswa, 200);
    }


    public function create()
    {
        //
    }
    public function store(Request $request)
    {
      // $request->validate([
      //   'nisn' => 'required',
      //   'nis' => 'required|size:3',
      //   'email' => 'required|unique:students,email|email',
      //   'jurusan' => 'required',
      // ])

      $siswa = Siswa::create($request->all());

      // $siswa = Siswa::create([
      //   'id' => $request->id,
      //   'nis' => $request->nis,
      //   'nama' => $request->nama,
      //   'id_kelas' => $request->id_kelas,
      //   'alamat' => $request->alamat,
      //   'no_telp' => $request->no_telp
      // ]);
      
      // $user = User::create([
      //   'name' => $request->nama
      // ]);

      // return response(null, 200);
      return response()->json($siswa, 200);
      // return response()->json([
      //   'siswa' => $siswa,
      //   'message' => 'Success'
      // ], 200);
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
      // info($request);
      // info($id);

      $siswa = Siswa::findOrFail($id);
      $user = User::where([
        'name' => $siswa->nama,
      ]);

      $siswa = $siswa->update([
          'id' => $request->id,
          'nis' => $request->nis,
          'nama' => $request->nama,
          'id_kelas' => $request->id_kelas,
          'alamat' => $request->alamat,
          'no_telp' => $request->no_telp
        ]);

      $user = $user->update([
        'name' => $request->nama,
      ]);

      // $siswa->update($request->all());

      return response()->json($siswa, 200);
    }

    public function destroy(Request $request, $id)
    {
      // return [$request, $id];
      $siswa = Siswa::where('id', $id)->delete();
      $user = User::where('name', $request->nama)->delete();

      // $user = User::where([
      //   'name' => $request->nama
      // ])->delete();

      // DB::table("siswa")->where("id", $id)->delete();
      // DB::table("user")->where("name", $request->nama)->delete();

      // return $user;

      return response(["Message" => "Success"], 200);
    }

    public function count()
    {
      $siswa = Siswa::count();

      return response($siswa, 200);
    }
}
