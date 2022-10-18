<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\RegistrasiPasien;
use App\Models\Rekammedis;
use App\Models\Reseps;
use App\Models\DetailResep;
use App\Models\Tindakan;
use PDF;
// use Dompdf

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Pembayaran::join('reseps', 'pembayarans.resep_id', '=', 'reseps.id')
                ->join('rekammedis', 'reseps.rekamedis_id', '=', 'rekammedis.id')
                ->join('obats', 'reseps.obat_id', '=', 'obats.id')
                ->join('tindakans', 'rekammedis.tindakan_id', '=', 'tindakan.id')
                ->join('pasiens', 'rekammedis.pasien_id', '=', 'pasien.id')
                ->get();
        }

        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
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
        $store = new Pembayaran();
        $store->user_id = $request->user_id;
        $store->regis_id = $request->registrasi_id;
        $store->resep_id = $request->id;
        $store->total_bayar = $request->total;
        $store->jumlah_bayar = $request->jumlah_bayar;
        $store->tgl_bayar = date('Y-m-d');
        $store->save();

        RegistrasiPasien::where('id', $request->registrasi_id)->update([
            'status' => 'selesai'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan!', 'data' => $this->filter($request)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pembayaran::where('id', $id)->first();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
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
        Pembayaran::where('id', $id)->update([
            'user_id' => $request->user_id,
            'regis_id' => $request->regis_id,
            'resep_id' => $request->resep_id,
            'total_bayar' => $request->total_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tgl_bayar' => $request->tgl_bayar,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah!', 'data' => $this->filter($request)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Pembayaran::where('id', $id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Pembayaran::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }


    public function global_function(Request $request)
    {

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";

        $data = Rekammedis::when(!empty($search), function ($query) use ($search) {
            $query->where('pasiens.nama', 'LIKE', '%' . $search . '%')
            ->orwhere('pasiens.id', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)
            ->join('registrasi_pasiens', 'rekammedis.registrasi_id', '=', 'registrasi_pasiens.id')
            ->join('pasiens', 'registrasi_pasiens.pasien_id', '=', 'pasiens.id')
            ->join('reseps', 'rekammedis.id', '=', 'reseps.rekamedis_id')
            ->join('tindakans', 'rekammedis.tindakan_id', '=', 'tindakans.id')
            ->where('registrasi_pasiens.jenis_pembayaran', 'umum')
            ->select('pasiens.id as pasien_id', 'registrasi_pasiens.id as regis_id', 'pasiens.nama', 'rekammedis.id as id', 'registrasi_pasiens.tgl', 'reseps.id as resep_id')
            ->paginate(10);

        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function printNota(Request $request, $id)
    {
        $data = Pembayaran::join('reseps', 'pembayarans.resep_id', '=', 'reseps.id')
            ->join('rekammedis', 'reseps.rekamedis_id', '=', 'rekammedis.id')
            ->join('tindakans', 'rekammedis.tindakan_id', '=', 'tindakans.id')
            ->join('pasiens', 'rekammedis.pasien_id', '=', 'pasiens.id')
            ->where('rekammedis.id', $id)
            ->select('pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.alamat', 'pasiens.no_hp', 'reseps.id as resep_id', 'rekammedis.tindakan_id', 'pembayarans.id', 'pembayarans.jumlah_bayar', 'pembayarans.total_bayar')
            ->first();
        // dd($data);
        $resep = DetailResep::join('obats', 'detailreseps.obat_id', '=', 'obats.id')
            ->join('reseps', 'detailreseps.resep_id', '=', 'reseps.id')
            ->where('resep_id', $data->resep_id)
            ->select('obats.nama', 'detailreseps.id', 'obats.harga', 'detailreseps.jumlah')
            ->get();

        $pisah = explode(',', $data->tindakan_id);
        // dd($resep);
        // print $pisah;
        $value = [];
        for ($x = 0; $pisah[$x] != null && $pisah[$x] != ""; $x++) {
            $tindakan =  Tindakan::where('id', $pisah[$x])
                ->select('tindakans.description', 'tindakans.harga')
                ->first();
            array_push($value, $tindakan);
        }

        $pdf = PDF::loadView('pdf.nota', ['data' => $data, 'resep' => $resep, 'tindakan' => $value]);
        $pdf->setPaper('a4', 'portrait');
        if ($request->download == 1) {
            return $pdf->download('nota' . time() . '.pdf');
        } else {
            return $pdf->stream('nota.pdf');
        }
    }

    public function printLaporanKeungan(Request $request)
    {
        $from = $request->awal;
        $to = $request->akhir;
        // dd($from, $to);
        $data = Pembayaran::join('registrasi_pasiens','pembayarans.regis_id','=','registrasi_pasiens.id')
        ->whereBetween('tgl_bayar',[$from, $to])
        ->select('pembayarans.id','pembayarans.total_bayar','pembayarans.jumlah_bayar','pembayarans.tgl_bayar','registrasi_pasiens.pasien_id')
        ->get();
        $pdf = PDF::loadView('pdf.laporankeungan',['data' => $data, 'from' => $from, 'to' => $to]);
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('laporan-keungan'.time().'.pdf');
    }
}
