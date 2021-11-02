<?php

namespace App\Http\Controllers;

use App\Models\Emergency;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmergancyController extends Controller
{
    public function index(Request $request)
    {
        if($this->cekAkses($request)->read == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

         if(isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Emergency::all();
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
            'entry_time' => 'required',
            'medical_activity_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }
        $store = new Emergency();
        // $store->id = Str::id();
        $store->entry_time = $request->entry_time;
        $store->medical_activity_id = $request->medical_activity_id;
        $store->polyclinic_id = $request->polyclinic_id;
        // $store->is_emergency = 1;
        // $store->superuser = $request->superuser ? 1 : 0;
        $store->save();

        $v_store = new Visit();
        $v_store->visit_in = $request->entry_time;
        $v_store->visit_number = $request->visit_number;
        $v_store->patient_id  = $request->patien_id;
        $v_store->case_id = $request->case_id;
        $v_store->reference_type_id = $request->reference_id;
        $v_store->origin_reference = $request->asal_rujukan;
        $v_store->reference_number = $request->no_rujukan;
        $v_store->reference_date = $request->date_reference;
        $v_store->pj_name = $request->pj_name;
        $v_store->pj_phone_number = $request->pj_phone_number;
        $v_store->payment_method_id = $request->payment_id;
        $v_store->sjp_number = $request->no_sjp;
        $v_store->sjp_date = $request->date_SJP;
        $v_store->save();
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
        $data = Emergency::where('id',$id)->first();
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

        Emergency::where('id', $id)->update([
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

        Emergency::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }
    
    
    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Emergency::when(!empty($search), function ($query) use ($search) {
            $query->where('description', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function filterPosition(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Emergency::when(!empty($search), function ($query) use ($search) {
            $query->where('position_id', '=', '2' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function global_function(Request $request){
        if (isset($request->limit)) {
            $data = $this->filterPosition($request);
        } else {
            $data = Emergency::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
