<?php

namespace App\Http\Controllers;

use App\Models\OutPatient;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OutPatienController extends Controller
{
    public function index(Request $request)
    {
        // if ($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if (isset($request->limit)) {
            $data = $this->filter($request);
            // dd($data);
        } else {
            $data = OutPatient::all();
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
    public function generateUniqCode()
    {
        do {
            $code = 'RJL' . random_int(1000000, 9999999);
        } while (Visit::where("visit_number", "=", $code)->first());

        return $code;
    }

    public function store(Request $request)
    {
        // if ($this->cekAkses($request)->create == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }
        $validator = Validator::make($request->all(), [
            'entry_time' => 'required',
            'medical_activity_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        // $store->id = Str::id();


        $v_store = new Visit();
        $v_store->visit_in = $request->entry_time;
        $v_store->visit_number = $this->generateUniqCode();
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

        $store = new OutPatient();
        $store->entry_time = $request->entry_time;
        $store->medical_activity_id = $request->medical_activity_id;
        $store->polyclinic_id = $request->polyclinic_id;
        $store->visit_id = $v_store->id;
        // $store->is_emergency = 1;
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
        $data = OutPatient::where('id', $id)->first();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
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
        if ($this->cekAkses($request)->update == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'nullable|unique:m_roles',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        OutPatient::where('id', $id)->update([
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
        // if ($this->cekAkses($request)->delete == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if ($id == null) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus!', 'errors' => 'ID kosong']);
        }

        OutPatient::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }


    public function filter(Request $request)
    {
        $searchRequest = $request->searchQuery;
        $results = [];
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = OutPatient::when(!empty($search), function ($query) use ($search) {
            $query->where('	final_condition', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);
        // dd($data);

        $post = DB::table('out_patients')
            ->join('visits', 'out_patients.visit_id', '=', 'visits.id')
            ->join('patients', 'visits.patient_id', '=', 'patients.id')
            ->select('visits.visit_number as visit_number', 'out_patients.entry_time as entry_time', 'out_patients.exit_time as exit_time', 'patients.name as name','out_patients.id')
            ->paginate(10);
        // dd($post);
        // return response()->json(['data' => $post, 'message' => 'Successfully.', 'status' => 'success']);

        return $post;
    }

    public function filterPosition(Request $request)
    {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = OutPatient::when(!empty($search), function ($query) use ($search) {
            $query->where('position_id', '=', '2' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filterPosition($request);
        } else {
            $data = OutPatient::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
    public function updatePasienPulang(Request $request, $id)
    {

        OutPatient::where('id', $id)->update([
            'exit_time' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getDetail(Request $request)
    {
        // $data = DB::table('out_patients')
        //         ->where('votes', '=', 100)
        //         ->get();
        $data = OutPatient::where('id', $request->param)->get();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
