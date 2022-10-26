<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use Barryvdh\DomPDF\Facade\Pdf;

class ObatController extends Controller
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
            $totalObat = Obat::count();
        }else{
            $data = Obat::all();
        }
        return response()->json(['data' => $data,'total' => $totalObat,'message' => 'Successfully.', 'status'=>'success']);
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

        $store = new Obat();
        $store->kategori_id = $request->kategori_id;
        $store->nama = $request->nama;
        $store->kandungan = $request->kandungan;
        $store->harga = $request->harga;
        $store->stock = $request->stock;
        $store->keterangan = $request->keterangan;
        $store->satuan = $request->satuan;
        $store->save();

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
        $data = Obat::where('id', $id)->first();
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
        $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
            'kandungan' => 'required',
            'harga' => 'required',
        ]);

        Obat::where('id', $id)->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'kandungan' => $request->kandungan,
            'harga' => $request->harga,
            'stock' => $request->stock,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
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
        Obat::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);

    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Obat::when(!empty($search), function ($query) use ($search) {
            $query->where('obats.nama', 'LIKE', '%' . $search . '%');
        })->join('kategori_obats','obats.kategori_id','=','kategori_obats.id')
        ->orderBy($request->sortBy, $request->orderBy)
        ->select('kategori_obats.kategori','obats.id','obats.nama','obats.kandungan','obats.harga','obats.stock','obats.keterangan','obats.satuan')
        ->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function global_function(Request $request)
    {
        // dd($request->obat);
        if (isset($request->limit)) {
            $data = $this->filter($request);
        }else if ($request->obat == 1){
            $data = Obat::all();
        } else {
            $data = Obat::where('stock','>', 12)->get();
        }
        
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function printLapObat(Request $request) 
    {
        // dd($request->laporan);
        if(isset($request->laporan)){
            $data = Obat::where('stock',0)->get();
            // dd($data);
        }else{
            $data = Obat::all();
            // dd($data);
        }

        $pdf = PDF::loadview('pdf.laporanobat_pdf',['data' => $data]);
        $pdf->setPaper('a4','portrait');
        return $pdf->download('laporan-obat'. time() .'.pdf');
    }

}
