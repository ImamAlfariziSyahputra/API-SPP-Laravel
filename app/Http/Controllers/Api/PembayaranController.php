<?php

namespace App\Http\Controllers\Api;

use App\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
  public function getToken(Request $request)
  {
    // return $request;
    $this->initPaymentGateway();

    if(!empty($request) && $request->status == 1) // Menampilkan UI metode pembayaran
    {
      $params = [
        'transaction_details' => array(
            'order_id' => $request->id,
            'gross_amount' => $request->jumlah_bayar,
        ),
        'customer_details' => array(
            'first_name' => "Okeng",
            'last_name' => 'Ganteng',
            'email' => 'budi.pra@example.com',
            'phone' => '08111222333',
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // return Pembayaran::all();

      $pembayaran = DB::table('pembayaran')
            ->join("user", "user.id", "=", "pembayaran.id_user")
            ->join("siswa", "siswa.id", "=", "pembayaran.nisn")
            ->join("spp", "spp.id", "=", "pembayaran.id_spp")
            ->select('pembayaran.*', 
                      'siswa.id as nisn', 'user.name as nama_petugas', 'spp.nominal as spp')
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

      // $pembayaran = Pembayaran::create($request->all());

      $pembayaran = Pembayaran::create([
        'id_user' => $request->id_user,
        'nisn' => $request->nisn,
        // 'nama' => $request->nama,
        // 'is_active' => $request->is_active,
        'tgl_bayar' => $request->tgl_bayar,
        'bulan_bayar' => $request->bulan_bayar,
        'tahun_bayar' => $request->tahun_bayar,
        'id_spp' => $request->id_spp,
        'jumlah_bayar' => $request->jumlah_bayar,
        'payment_token' => null,
      ]);

      // return response(null, 200);
      return response()->json($pembayaran, 200);
      // return response()->json([
      //   'siswa' => $pembayaran,
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

      $pembayaran = Pembayaran::findOrFail($id);
      $pembayaran->update($request->all());

      return response()->json($pembayaran, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $pembayaran = Pembayaran::where('id', $id)->delete();

      return response($pembayaran, 200);
    }
}
