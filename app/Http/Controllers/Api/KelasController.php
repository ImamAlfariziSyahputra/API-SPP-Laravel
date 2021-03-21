<?php

namespace App\Http\Controllers\Api;

use App\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // return Kelas::all();

      $kelas = DB::table('kelas')
            ->join("jurusan", "jurusan.id", "=", "kelas.id_jurusan")
            ->select('kelas.*', 'jurusan.nama_jurusan as nama_jurusan')
            ->get();

      // dd($kelas);

      // $kelas = Kelas::select(
      //   "kelas.id", 
      //   "kelas.nama_kelas",
      //   "kelas.id_jurusan",
      //   "jurusan.nama_jurusan as nama_jurusan",
      // )
      // ->join("jurusan", "jurusan.id", "=", "kelas.id_jurusan")
      // ->get();

      // dd($kelas);
      return response()->json($kelas, 200);
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
      // $request->validate([
      //   'nisn' => 'required',
      //   'nis' => 'required|size:3',
      //   'email' => 'required|unique:students,email|email',
      //   'jurusan' => 'required',
      // ])

      $kelas = Kelas::create($request->all());

      // $kelas = User::create([
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
      return response()->json($kelas, 200);
      // return response()->json([
      //   'siswa' => $kelas,
      //   'message' => 'Success'
      // ], 200);
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
      // info($request);
      // info($id);

      $kelas = Kelas::findOrFail($id);
      $kelas->update($request->all());

      return response()->json($kelas, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $kelas = Kelas::where('id', $id)->delete();

      return response($kelas, 200);
    }

    public function count()
    {
      $kelas = Kelas::count();

      return response($kelas, 200);
    }
}
