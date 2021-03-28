<?php

namespace App\Http\Controllers\Api;

use App\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class JurusanController extends Controller
{
    
    public function index()
    {
      return Jurusan::all();
    }

    public function count()
    {
      $jurusan = Jurusan::count();

      return response($jurusan, 200);
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

      $jurusan = Jurusan::create($request->all());

      // $jurusan = User::create([
      //   'nisn' => $request('nisn'),
      //   'nis' => $request('nis'),
      //   'nama' => $request('nama'),
      //   'is_active' => $request('is_active'),
      //   'id_kelas' => $request('id_kelas'),
      //   'alamat' => $request('alamat'),
      //   'no_telp' => $request('no_telp'),
      //   'id_spp' => $request('id_spp')
      // ]);

      // return response(null, 200);
      return response()->json($jurusan, 200);
      // return response()->json([
      //   'siswa' => $jurusan,
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

      $jurusan = Jurusan::findOrFail($id);
      $jurusan->update($request->all());

      return response()->json($jurusan, 200);
    }

    public function destroy($id)
    {
      $jurusan = Jurusan::where('id', $id)->delete();

      return response($jurusan, 200);
    }
}
