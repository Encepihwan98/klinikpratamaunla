<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObatMasuk;
use App\Models\Obat;

class ObatMasukController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
            // dd($data);
        } else {
            $data = ObatMasuk::all();
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
        // $request->validate([
        //     'kategori_id' => 'required',
        //     'nama' => 'required',
        //     'kandungan' => 'required',
        //     'harga' => 'required',
        //     'keterangan' => 'keterangan'
        // ]);

        $store = new ObatMasuk();
        $store->obat_id = $request->obat_id;
        $store->suplier_id = $request->suplier_id;
        $store->jumlah_masuk = $request->jumlah_masuk;
        $store->tgl = $request->tgl;
        $store->save();

        $obat = Obat::findOrFail($request->obat_id);
        $obat->stock += $request->jumlah_masuk;
        $obat->save();

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
        $data = ObatMasuk::where('id', $id)->first();
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
        $request->validate([
            'obat_id' => 'required',
            'suplier_id' => 'required',
            'jumlah_masuk' => 'required',
            'tgl' => 'required',
        ]);

        ObatMasuk::where('id', $id)->update([
            'obat_id' => $request->obat_id,
            'suplier_id' => $request->suplier_id,
            'jumlah_masuk' => $request->jumlah_masuk,
            'tgl' => $request->harga,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        ObatMasuk::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = ObatMasuk::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->join('obats', 'obat_masuks.obat_id', '=', 'obats.id')
        ->join('supliers','obat_masuks.suplier_id','=','supliers.id')
            ->orderBy($request->sortBy, $request->orderBy)
            ->select('obat_masuks.id', 'obats.nama', 'obat_masuks.tgl', 'obat_masuks.jumlah_masuk', 'supliers.nama as nama_supliers', 'obats.stock', 'obats.keterangan')
            ->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

}
