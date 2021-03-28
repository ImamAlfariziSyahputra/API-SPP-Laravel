<?php

namespace App\Http\Controllers\Api;

use App\Spp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SppController extends Controller
{
    
    public function index()
    {
      return Spp::all();
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

      $spp = Spp::create($request->all());

      // $spp = User::create([
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
      return response()->json($spp, 200);
      // return response()->json([
      //   'siswa' => $spp,
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

      $spp = Spp::findOrFail($id);
      $spp->update($request->all());

      return response()->json($spp, 200);
    }

    public function destroy($id)
    {
      $spp = Spp::where('id', $id)->delete();

      return response($spp, 200);
    }
}
