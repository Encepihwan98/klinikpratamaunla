<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\RegistrasiPasien;
use App\Models\Reseps;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->limit)){
            $data = $this->filter($request);
        }else{
            $data = Pembayaran::join('reseps','pembayarans.resep_id','=','reseps.id')
            ->join('rekammedis','reseps.rekamedis_id','=','rekammedis.id')
            ->join('obats','reseps.obat_id','=','obats.id')
            ->join('tindakans','rekammedis.tindakan_id','=','tindakan.id')
            ->join('pasiens','rekammedis.pasien_id','=','pasien.id')
            ->get();

        }

        return response()->json(['data' => $data,'message' => 'Successfully.', 'status'=>'success']); 
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
        $store->user_id = $request->user_id ;
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
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status'=>'success']);
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
    public function destroy(Request $request,$id)
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


    public function global_function(Request $request){
        
        $data = RegistrasiPasien::join('pasiens','registrasi_pasiens.pasien_id','=','pasiens.id')
        ->join('rekammedis','pasiens.id','=','rekammedis.pasien_id')
        ->join('reseps','rekammedis.id','=','reseps.rekamedis_id')
        ->join('tindakans','rekammedis.tindakan_id','=','tindakans.id')
        ->where('registrasi_pasiens.jenis_pembayaran','umum')
        ->select('pasiens.id as pasien_id','registrasi_pasiens.id','pasiens.nama','rekammedis.id as rekamedis_id','registrasi_pasiens.tgl','reseps.id as resep_id')
        ->paginate(10);
        
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
