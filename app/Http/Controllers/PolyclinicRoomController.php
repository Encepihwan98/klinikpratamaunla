<?php

namespace App\Http\Controllers;

use App\Models\PolyclinicRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ServiceRate;

class PolyclinicRoomController extends Controller
{
    public function index(Request $request)
    {
        if($this->cekAkses($request)->read == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

         if(isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = PolyclinicRoom::all();
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
            'name' => 'required|unique:m_roles',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }
        $store = new PolyclinicRoom();
        // $store->id = Str::id();
        $store->polyclinic_id = $request->polyclinic_id;
        $store->name = $request->name;
        $store->type = $request->jenis;
        $store->grade_id = $request->grade_id;
        // $store->superuser = $request->superuser ? 1 : 0;
        $store->save();
        $store->id;

        $store1 = new ServiceRate();
        
        $models   = collect(get_declared_classes())->filter(function ($item) {
            return (substr($item, 0, 11) === 'App\Models\\');
        });
        $store1->service_type = $models;
        $store1->tarifable_id = $store;
        $store1->service_uuid = Str::uuid();
        $store1->service_rate = '{"KELAS_I":{"SARANA":"0","PELAYANAN":"0","BHP":"0"},"KELAS_II":{"SARANA":"0","PELAYANAN":"0","BHP":"0"},"KELAS_III":{"SARANA":"0","PELAYANAN":"0","BHP":"0"},"KELAS_KS":{"SARANA":"0","PELAYANAN":"0","BHP":"0"},"KELAS_VIP":{"SARANA":"0","PELAYANAN":"0","BHP":"0"}}';
        $store1->save();

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
        $data = PolyclinicRoom::where('id',$id)->first();
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

        PolyclinicRoom::where('id', $id)->update([
            'polyclinic_id' => $request->polyclinic_id,
            'name' => $request->name,
            'type' => $request->jenis,
            'grade_id' => $request->grade_id,
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

        PolyclinicRoom::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }
    
    
    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = PolyclinicRoom::when(!empty($search), function ($query) use ($search) {
            $query->where('description', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }
    public function global_function(Request $request){
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = PolyclinicRoom::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function select_function($id)
    {
        $data = PolyclinicRoom::where('polyclinic_id',$id)->first();
        return response()->json(['data' => $data,'message' => 'Successfully.', 'status'=>'success']);
    }
}
