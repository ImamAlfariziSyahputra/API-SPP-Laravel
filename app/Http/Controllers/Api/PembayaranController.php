<?php

namespace App\Http\Controllers\Api;

use App\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Siswa;
use App\Spp;
use App\User;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
  public function getToken(Request $request)
  {
    // return $request;
    $this->initPaymentGateway();

    if(!empty($request) && $request->status == 1) // Menampilkan UI metode pembayaran
    {
      // $spp = Spp::where('id', $request->id_spp)->first();
      // $siswa = Siswa::where('id', $request->nisn)->first();
      $user = User::where('name', $request->nama)->first();
      $params = [
        'transaction_details' => array(
            'order_id' => $request->id,
            'gross_amount' => $request->jumlah_bayar,
        ),
        'customer_details' => array(
            'first_name' => $request->nama,
            'email' => $user->email,
            'phone' => $request->no_telp,
        ),
      ];

        $snap = \Midtrans\Snap::getSnapToken($params);
        return response()->json($snap, 200);
    }
  }

  public function changeStatus(Request $request)
  {
    if($request->order_id)  // SETELAH MENDAPAT TOKEN
      {
        // $order_id = $request->order_id;
        $pembayaran = Pembayaran::where('id', $request->order_id)->first();
        // return $pembayaran;
        $pembayaran->status = 2;
        $pembayaran->update();

        return response()->json($pembayaran, 200);
      }
  }

  public function detailHistory(Request $request)
  {
    $this->initPaymentGateway();

    // dd($request);
    $status = \Midtrans\Transaction::status($request->id);
    $status = json_decode(json_encode($status), true);
    // dd($status);
    $va_number = $status['va_numbers'][0]['va_number'];
    $gross_amount = $status['gross_amount'];
    $bank = $status['va_numbers'][0]['bank'];
    $transaction_status = $status['transaction_status'];
    $transaction_time = $status['transaction_time'];
    $deadline = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));

    return response()->json([
      'va_number'=> $va_number,
      'gross_amount'=> $gross_amount,
      'bank'=> $bank,
      'transaction_status'=> $transaction_status,
      'deadline'=> $deadline
    ], 200);
  }

  public function index()
  {
    // return Pembayaran::all();

    $pembayaran = DB::table('pembayaran')
          ->join("user", "user.id", "=", "pembayaran.id_user")
          ->join("siswa", "siswa.id", "=", "pembayaran.nisn")
          ->join("spp", "spp.id", "=", "pembayaran.id_spp")
          ->select('pembayaran.*', 
                    'siswa.id as id_siswa',
                    'siswa.nama as nama',
                    'siswa.id_kelas as id_kelas',
                    'siswa.no_telp as no_telp',
                    'user.name as nama_petugas',
                    'spp.nominal as spp')
          ->get();

    return response()->json($pembayaran, 200);
  }

  public function paymentHistory()
  {
    // return Pembayaran::all();

    $pembayaran = DB::table('pembayaran')
          ->join("user", "user.id", "=", "pembayaran.id_user")
          ->join("siswa", "siswa.id", "=", "pembayaran.nisn")
          ->join("spp", "spp.id", "=", "pembayaran.id_spp")
          ->select('pembayaran.*', 
                    'siswa.id as nisn', 'user.name as nama_petugas', 'spp.nominal as spp')
          ->where('status', 2)
          ->get();

    return response()->json($pembayaran, 200);
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

    // $pembayaran = Pembayaran::create($request->all());

    $spp = Spp::where('id', $request->id_spp)->first();

    $pembayaran = Pembayaran::create([
      'id_user' => $request->id_user,
      'nisn' => $request->nisn,
      // 'nama' => $request->nama,
      // 'is_active' => $request->is_active,
      'tgl_bayar' => $request->tgl_bayar,
      'bulan_bayar' => $request->bulan_bayar,
      'tahun_bayar' => $request->tahun_bayar,
      'id_spp' => $request->id_spp,
      'jumlah_bayar' => $spp->nominal,
      'status' => 1,
    ]);

    // return response(null, 200);
    return response()->json($pembayaran, 200);
    // return response()->json([
    //   'siswa' => $pembayaran,
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

    $pembayaran = Pembayaran::findOrFail($id);
    $spp = Spp::where('id', $request->id_spp)->first();

    $pembayaran->update([
      'id_user' => $request->id_user,
      'nisn' => $request->nisn,
      'tgl_bayar' => $request->tgl_bayar,
      'bulan_bayar' => $request->bulan_bayar,
      'tahun_bayar' => $request->tahun_bayar,
      'id_spp' => $request->id_spp,
      'jumlah_bayar' => $spp->nominal
    ]);

    return response()->json($pembayaran, 200);
  }

  public function destroy($id)
  {
    $pembayaran = Pembayaran::where('id', $id)->delete();

    return response($pembayaran, 200);
  }
}
