<?php

namespace App\Http\Controllers;

use App\Models\ReferenceType;
use Illuminate\Http\Request;
use App\Models\Rujukan;
use PDF;
use Illuminate\Support\Facades\Validator;

class RujukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        // }

         if(isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Rujukan::all();
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
        if($this->cekAkses($request)->create == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|unique:m_roles',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }
        $store = new Rujukan();
        // $store->id = Str::id();
        $store->description = $request->description;
        // $store->superuser = $request->superuser ? 1 : 0;
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
        $data = Rujukan::where('id',$id)->first();
        return response()->json(['data' => $data,'message' => 'Successfully.', 'status'=>'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->cekAkses($request)->update == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'nullable|unique:m_roles',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        Rujukan::where('id', $id)->update([
            'description' => $request->description,
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
        if($this->cekAkses($request)->delete == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }
        
        if ($id == null) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus!', 'errors' => 'ID kosong']);
        }

        Rujukan::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }
    
    
    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Rujukan::when(!empty($search), function ($query) use ($search) {
            $query->where('description', 'LIKE', '%' . $search . '%');
        })
        ->join('rekammedis','rujukans.rekamedis_id','=','rekammedis.id')
        ->join('pasiens','rekammedis.pasien_id','=','pasiens.id')
        // ->join('registrasi_pasiens','pasiens.id','=','registrasi_pasiens.pasien_id')
        // ->orderBy($request->sortBy, $request->orderBy)
        ->select('pasiens.nama','rujukans.id','rujukans.rujukan','rekammedis.tgl')
        ->paginate($request->limit != "" ? $request->limit : 10);
        // dd($data);
        return $data;
    }
    
    public function printSuratRujukan(Request $request, $id)
    {
        // dd($id);
        $data = Rujukan::join('rekammedis','rujukans.rekamedis_id','=','rekammedis.id')
        ->join('pasiens','rekammedis.pasien_id','=','pasiens.id')
        ->where('rujukans.id', $id)
        ->select('pasiens.id as pasien_id','pasiens.nama as nama','pasiens.alamat','pasiens.tgl_lahir',
        'pasiens.jenis_kelamin','rekammedis.anamnesis','rekammedis.keterangan','rujukans.rujukan')
        ->first();
        // dd($data);
        $pdf = PDF::loadview('pdf.suratrujukan',['data' => $data]);
        return $pdf->download('surat-rujukan.pdf');

    }
}
