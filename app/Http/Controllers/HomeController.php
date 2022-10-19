<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\Pembayaran;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        
        $totalToday = Pasien::wheredate('created_at', date('Y-m-d'))->count();
        
        $totalMonth = Pasien::whereMonth('created_at', date('m'))->count();
        
        $totalAll = Pasien::count();
        
        $totalUmum = Pasien::join('registrasi_pasiens','pasiens.id','registrasi_pasiens.pasien_id')
        ->where('registrasi_pasiens.jenis_pembayaran', 'Umum')
        ->count();
        
        $totalBPJS = Pasien::join('registrasi_pasiens','pasiens.id','registrasi_pasiens.pasien_id')
        ->where('registrasi_pasiens.jenis_pembayaran', 'BPJS')
        ->count();
        
        $totalObat = Obat::count();
        
        $uang = Pembayaran::all();
        $total = 0;
        foreach($uang as $uangs) {
            $total +=  $uangs->total_bayar;
        }
        
        $data = array("total" => $total, "totalObat" => $totalObat, "totalBPJS" => $totalBPJS, "totalUmum" => $totalUmum, "totalAll" => $totalAll, 
        "totalMonth" => $totalMonth, "totalToday" => $totalToday);
        
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
