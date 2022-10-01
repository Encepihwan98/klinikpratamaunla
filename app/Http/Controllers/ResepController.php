<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reseps;
use App\Models\Obat;
use App\Models\DetailResep;
use App\Models\Pasien;

class ResepController extends Controller
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
            // dd($data);
        } else {
            $data = Reseps::all();
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
        $data = Reseps::where('id', $id)->first();
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
        Reseps::where('id', $id)->update([
            'rekamedis_id' => $request->rekamedis_id,
            'apoteker_id' => $request->apoteker_id,
            'obat_id' => $request->obat_id,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'jumlah' => $request->jumlah,
            'tgl_resep' => $request->tgl_resep,
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
        Reseps::where('id', $id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Reseps::when(!empty($search), function ($query) use ($search) { // 6
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
            ->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        // select data dari apoteker $data[0]['apoteker_id'] = 1
        // $data[0-6]['apoteker_id'] = 1

        // $data_ahkir = []
        // $data_akhir['obat'] = $data
        // $data_akhir['apoteker'] = $data_apoteker

        return $data;
    }

    public function getStatusResep()
    {
        $data = Reseps::join('rekammedis', 'reseps.rekamedis_id', '=', 'rekammedis.id')
            ->join('pasiens', 'rekammedis.pasien_id', '=', 'pasiens.id')
            ->where('reseps.status', 'belum')
            ->where('reseps.tgl_resep', date('Y-m-d'))
            ->select('reseps.status', 'reseps.id', 'pasiens.nama', 'rekammedis.id as rekamedis_id')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => '200']);
    }

    // detail resep
    public function getDetailResep(Request $request)
    {

        // dd($request->param);
        $data = DetailResep::join('obats', 'detailreseps.obat_id', '=', 'obats.id')
            ->join('reseps', 'detailreseps.resep_id', '=', 'reseps.id')
            ->where('resep_id', $request->param)
            ->select('obats.nama', 'detailreseps.id', 'obats.harga', 'detailreseps.jumlah')
            ->get();

        $value = Reseps::join('rekammedis', 'reseps.rekamedis_id', '=', 'rekammedis.id')
            ->join('registrasi_pasiens', 'registrasi_id', '=', 'registrasi_pasiens.id')
            ->join('pasiens', 'rekammedis.pasien_id', '=', 'pasiens.id')
            ->where('reseps.id', $request->param)
            ->select('reseps.id', 'reseps.tgl_resep', 'pasiens.nama', 'registrasi_pasiens.id as registrasi_id')
            ->first();
        return response()->json(['data' => $data, 'value' => $value, 'message' => 'Successfully.', 'status' => '200']);
    }

    public function getStatusResepToday()
    {
        $data = Reseps::join('rekammedis', 'reseps.rekamedis_id', '=', 'rekammedis.id')
            ->join('pasiens', 'rekammedis.pasien_id', '=', 'pasiens.id')
            ->where('reseps.tgl_resep', date('Y-m-d'))
            ->select('reseps.status', 'reseps.id', 'pasiens.nama', 'reseps.rekamedis_id')->paginate(20);
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => '200']);
    }

    public function updateStatusResep(Request $request, $id)
    {
        $data = Reseps::where('id', $id)->update([
            'status' => 'selesai',
        ]);
        return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah!', 'data' => $this->filter($request)]);
    }

    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Reseps::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function resep_pasien(Request $request, $id)
    {
        $data = Reseps::join('detailreseps', 'detailreseps.resep_id', '=', 'reseps.id')
            ->join('obats', 'detailreseps.obat_id', '=', 'obats.id')
            ->join('rekammedis', 'reseps.rekamedis_id', '=', 'rekammedis.id')
            ->join('pasiens', 'pasiens.id', '=', 'rekammedis.pasien_id')
            ->where('pasiens.id', $id)
            ->orderby('reseps.tgl_resep', 'asc')
            ->select('reseps.id', 'obats.nama as nama_obat', 'detailreseps.jumlah', 'detailreseps.harga', 'rekammedis.keluhan', 'pasiens.nama','reseps.tgl_resep')
            ->get();

        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function listPasien(Request $request)
    {
        $data = Pasien::select(
            'pasiens.id as id_',
            'pasiens.nama',
            'pasiens.no_ktp',
            'pasiens.jenis_kelamin',
            'pasiens.tgl_lahir',
            'pasiens.pekerjaan',
            'pasiens.no_hp',
            'pasiens.alamat',
            'pasiens.dokter_id',
            // 'users.name as user_nama'
        )
            ->paginate (10);
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
