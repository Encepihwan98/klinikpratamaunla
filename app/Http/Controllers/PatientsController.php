<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->cekAkses($request)->read == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        if(isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Patient::all();
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
            'pendidikan_id' => 'required',
            'identity_id' => 'required',
            'identity_number' => 'required',
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'blood_group' => 'required',
            'address' => 'required',
            'province_id' => 'required',
            'phone_number' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'partner_name' => 'required',
            'family_phone_number' => 'required',
            'family_address' => 'required',
            'agama_id' => 'required',
            'tribe_id' => 'required',
            'profession_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }
        $store = new Patient();
        // $store->id = Str::id();
        $store->education_id = $request->pendidikan_id;
        $store->identity_number_id = $request->identity_id;
        $store->identity_number = $request->identity_number;
        $store->name = $request->name;
        $store->birth_place = $request->birth_place;
        $store->birth_date = $request->birth_date;
        $store->gender = $request->gender;
        $store->blood_group = $request->blood_group;
        $store->address = $request->address;
        $store->province_id = $request->province_id;
        $store->phone_number = $request->phone_number;
        $store->father_name = $request->father_name;
        $store->mother_name = $request->mother_name;
        $store->merriage_status = $request->merriage_status;
        $store->partner_name = $request->partner_name;
        $store->family_phone_number = $request->family_phone_number;
        $store->family_address = $request->family_address;
        $store->agama_id  = $request->agama_id ;
        $store->tribe_id = $request->tribe_id;
        $store->proffesion_id = $request->profession_id;
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
        $data = Patient::where('id',$id)->first();
        return response()->json(['data' => $data,'message' => 'Successfully.', 'status'=>'success']);
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
        if($this->cekAkses($request)->update == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'nullable|unique:m_roles',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        Patient::where('id', $id)->update([
            'education_id' => $request->pendidikan_id,
            'identity_number_id' => $request->identity_id,
            'identity_number' => $request->identity_number,
            'name' => $request->name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'phone_number' => $request->phone_number,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'merriage_status' => $request->merriage_status,
            'partner_name' => $request->partner_name,
            'family_phone_number' => $request->family_phone_number,
            'family_address' => $request->family_address,
            'agama_id'  => $request->agama_id,
            'tribe_id' => $request->tribe_id,
            'proffesion_id' => $request->profession_id,
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

        Patient::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request) {
        $module = array();
        $compareModule = array();
        $fixModule = array();
        
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Patient::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }
    public function global_function(Request $request){
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Patient::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
