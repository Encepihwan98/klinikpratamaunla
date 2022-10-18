<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekammedis;
use App\Models\Reseps;
use App\Models\Rujukan;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Dokter;
use App\Models\RegistrasiPasien;
use App\Models\DetailResep;
use Namshi\JOSE\Signer\SecLib\RSA;
use Svg\Tag\Rect;

class RekamedisController extends Controller
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
            $data = Rekammedis::all();
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
    public function tambahDataRekamedis(Request $request){
        $store = new Rekammedis();
        $store->bb = $request->bb;
        $store->tb = $request->tb;
        $store->tensi = $request->td;
        $store->pasien_id = $request->pasien_id;
        $store->registrasi_id = $request->regis_id;
        $store->save();

        RegistrasiPasien::where('id', $request->regis_id)->update([
            'status' => 'checkup'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan!', 'data' => $this->filter($request)]);
    }

    public function store(Request $request)
    {
        $tindakan = "";
        foreach ($request->rekamedis['tindakan'] as $data) {
            $tindakan .= Tindakan::where('description', $data['text'])->first()['id'] . ",";
        }

        $store = new Rekammedis();
        $store->bb = $request->rekamedis['bb'];
        $store->tb = $request->rekamedis['tb'];
        $store->tensi = $request->rekamedis['tensi'];
        $store->pasien_id = $request->rekamedis['pasien_id'];
        $store->tindakan_id = $tindakan;
        $store->registrasi_id = $request->rekamedis['regis_id'];
        $store->dokter_id = Dokter::where('user_id', $request->user()->id)->first()['id'];
        $store->keluhan = $request->rekamedis['keluhan'];
        $store->anamnesis = $request->rekamedis['anamnesis'];
        $store->keterangan = $request->rekamedis['keterangan'];
        $store->tgl = date('Y-m-d');
        $store->save();

        $resep = new Reseps();
        $resep->status = 'belum';
        $resep->tgl_resep = date('Y-m-d');
        $resep->rekamedis_id = $store->id;
        // $resep->apoteker_id = $request->user()->id;
        $resep->save();

        foreach ($request->obat as $obat) {
            // dd($obat['name']);
            // dd(Obat::where('nama', $obat['name'])->first()['id']);
            $pisah = explode('-', $obat['name']);
            // dd(Obat::where('id', $pisah[0])->first()['id']);
            $store1 = new DetailResep();
            $store1->resep_id = $resep->id;
            $store1->obat_id = Obat::where('id', $pisah[0])->first()['id'];
            $store1->jumlah = $obat['total'];
            $store1->keterangan = $obat['desc'];
            $store1->harga = Obat::where('id', $pisah[0])->first()['harga'];
            $store1->save();

            $id = Obat::where('id', $pisah[0])->first()['id'];
            
            $stock = Obat::findOrFail($id);
            $stock->stock -= $obat['total'];
            $stock->save();
        }

        RegistrasiPasien::where('id', $request->rekamedis['regis_id'])->update([
            'status' => 'obat'
        ]);
        
        if(isset($request->rekamedis['rujukan'])){
            $store3 = new Rujukan();
            $store3->rekamedis_id = $store->id;
            $store3->rujukan = $request->rekamedis['rujukan'];
            $store3->save();
        }


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
        $data = Rekammedis::where('id', $id)->first();
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
        $tindakan = "";
        foreach ($request->rekamedis['tindakan'] as $data) {
            $tindakan .= Tindakan::where('description', $data['text'])->first()['id'] . ",";
        }
        // dd($tindakan);
        $dokter_id = Dokter::where('user_id', $request->user()->id)->first()['id'];

        Rekammedis::where('id', $id)->update([
            'pasien_id' => $request->rekamedis['pasien_id'],
            'tindakan_id' => $tindakan,
            'bb' => $request->rekamedis['bb'],
            'tb' => $request->rekamedis['tb'],
            'tensi' => $request->rekamedis['tensi'],
            'keluhan' => $request->rekamedis['keluhan'],
            'anamnesis' => $request->rekamedis['anamnesis'],
            'keterangan' => $request->rekamedis['keterangan'],
            'dokter_id' => $dokter_id,
            'tgl' => date('Y-m-d'),
        ]);
        // dd($id);
        if(isset($request->rekamedis['rujukan'])){
            $store3 = new Rujukan();
            $store3->rekamedis_id = $id;
            $store3->rujukan = $request->rekamedis['rujukan'];
            $store3->save();
        }


        $resep = new Reseps();
        $resep->status = 'belum';
        $resep->tgl_resep = date('Y-m-d');
        $resep->rekamedis_id = $id;
        // $resep->apoteker_id = $request->user()->id;
        $resep->save();

        foreach ($request->obat as $obat) {
            // dd($obat['name']);
            // dd(Obat::where('nama', $obat['name'])->first()['id']);
            $pisah = explode('-', $obat['name']);
            // dd(Obat::where('id', $pisah[0])->first()['id']);
            $store1 = new DetailResep();
            $store1->resep_id = $resep->id;
            $store1->obat_id = Obat::where('id', $pisah[0])->first()['id'];
            $store1->jumlah = $obat['total'];
            $store1->keterangan = $obat['desc'];
            $store1->harga = Obat::where('id', $pisah[0])->first()['harga'];
            $store1->save();

            $id = Obat::where('id', $pisah[0])->first()['id'];
            
            $stock = Obat::findOrFail($id);
            $stock->stock -= $obat['total'];
            $stock->save();
        }

        RegistrasiPasien::where('id', $request->rekamedis['regis_id'])->update([
            'status' => 'obat'
        ]);
        
        // dd($id);
        
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
        Rekammedis::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Rekammedis::when(!empty($search), function ($query) use ($search) {
            $query->where('pasiens.nama', 'LIKE', '%' . $search . '%');
        })
            ->join('pasiens', 'rekammedis.pasien_id', '=', 'pasiens.id')
            ->join('tindakans', 'rekammedis.tindakan_id', '=', 'tindakans.id')
            ->orderBy($request->sortBy, $request->orderBy)
            ->select('rekammedis.id', 'pasiens.nama', 'pasiens.id as pasien_id', 'tindakans.description as tindakan', 'rekammedis.bb', 'rekammedis.tb', 'rekammedis.tensi', 'rekammedis.keluhan', 'rekammedis.anamnesis', 'rekammedis.keterangan', 'rekammedis.tgl', 'rekammedis.tindakan_id')
            ->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function getTindakan(Request $request)
    {
        $data = Rekammedis::join('reseps','rekammedis.id','=','reseps.rekamedis_id')
        ->where('reseps.id', $request->param)
        ->first();
        $pisah = explode(',', $data->tindakan_id);
        // dd($pisah);
        // print $pisah;
        $value = [];
        for ($x = 0; $pisah[$x] != null && $pisah[$x] != ""; $x++) {
            $tindakan =  Tindakan::where('id', $pisah[$x])
                ->select('tindakans.description', 'tindakans.harga')
                ->first();
            array_push($value, $tindakan);
        }
        // dd($value);
        return response()->json(['data' => $value,  'message' => 'Successfully.', 'status' => 'success']);
    }

    public function listRekamedisPasien(Request $request, $id)
    {
        // dd($id);
        $data = Rekammedis::join('registrasi_pasiens','rekammedis.registrasi_id','=','registrasi_pasiens.id')
        ->join('pasiens','registrasi_pasiens.pasien_id','=','pasiens.id')
        ->where('pasiens.id', $id)
        ->select('rekammedis.id','rekammedis.bb','rekammedis.tb','rekammedis.tgl','rekammedis.tensi','rekammedis.keluhan','anamnesis','registrasi_pasiens.jenis_pembayaran')
        ->paginate(10);

        return response()->json(['data' => $data,  'message' => 'Successfully.', 'status' => 'success']);
    }

    public function getRekamedis(Request $request) {
        $data = Rekammedis::join('registrasi_pasiens','rekammedis.registrasi_id','=','registrasi_pasiens.id')
        ->where('registrasi_pasiens.id', $request->param)
        ->select('rekammedis.id as id','rekammedis.bb','rekammedis.tb','rekammedis.tensi')
        ->first();
        // dd($data);
        return response()->json(['data' => $data,  'message' => 'Successfully.', 'status' => 'success']);
    }
}
