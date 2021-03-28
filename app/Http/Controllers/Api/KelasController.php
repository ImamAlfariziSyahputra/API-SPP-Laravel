<?php

namespace App\Http\Controllers\Api;

use App\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    
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

      $kelas = Kelas::findOrFail($id);
      $kelas->update($request->all());

      return response()->json($kelas, 200);
    }

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

    // public function test()
    // {
    //   $kelas = DB::table('kelas')
    //         ->join("jurusan", "jurusan.id", "=", "kelas.id_jurusan")
    //         ->select('kelas.*', 'jurusan.nama_jurusan as nama_jurusan')
    //         ->get();

      
    //   return response()->json($kelas, 200);
    // }

    public function classPerMajorCount()
    {
      $rpl = Kelas::where([
        'id_jurusan' => 1,
      ])->count();

      $tkj = Kelas::where([
        'id_jurusan' => 2,
      ])->count();

      $tei = Kelas::where([
        'id_jurusan' => 3,
      ])->count();

      $bc = Kelas::where([
        'id_jurusan' => 4,
      ])->count();

      $mm = Kelas::where([
        'id_jurusan' => 5,
      ])->count();
      

      $total = [$rpl, $tkj, $tei, $bc, $mm];

      // $total = DB::table('kelas')
      //      ->where('id_jurusan', 1)
      //      ->orWhere('id_jurusan', 2)
      //      ->orWhere('id_jurusan', 3)
      //     //  ->where('id_jurusan', 4)
      //     //  ->where('id_jurusan', 5)
      //      ->get();

      return response()->json($total, 200);
      dd($total);
    }
}
