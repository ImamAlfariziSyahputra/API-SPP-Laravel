<?php

namespace App\Http\Controllers\Api;

use App\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // return Siswa::all();
      $siswa = DB::table('siswa')
            ->join('kelas', 'kelas.id', '=', 'siswa.id_kelas')
            ->join("spp", "spp.id", "=", "siswa.id_spp")
            ->select('siswa.*', 'kelas.nama_kelas as nama_kelas', 'spp.nominal as spp')
            ->get();

      // dd($siswa);

      // $siswa = Siswa::select(
      //   "siswa.id", 
      //   "siswa.nis",
      //   "siswa.nama",
      //   "siswa.id_kelas",
      //   "siswa.alamat",
      //   "siswa.no_telp",
      //   "siswa.id_spp",
      //   "kelas.nama_kelas as nama_kelas",
      //   "spp.nominal as spp",
      // )
      // ->join("kelas", "kelas.id", "=", "siswa.id_kelas")
      // ->join("spp", "spp.id", "=", "siswa.id_spp")
      // ->get();

      // dd($siswa);
      return response()->json($siswa, 200);
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

      $siswa = Siswa::create($request->all());

      // $siswa = User::create([
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
      return response()->json($siswa, 200);
      // return response()->json([
      //   'siswa' => $siswa,
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

      $siswa = Siswa::findOrFail($id);
      $siswa->update($request->all());

      return response()->json($siswa, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $siswa = Siswa::where('id', $id)->delete();

      return response($siswa, 200);
    }

    public function count()
    {
      $siswa = Siswa::count();

      return response($siswa, 200);
    }
}
