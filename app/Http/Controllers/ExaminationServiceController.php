<?php

namespace App\Http\Controllers;

use App\Models\ExamintaionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

class ExaminationServiceController extends Controller
{
    public function index(Request $request)
    {
        // if ($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = ExamintaionService::join('m_general_examinations', 'examintaion_services.general_examination_id', '=', 'm_general_examinations.id')
            ->join('employees', 'examintaion_services.officer_id', '=', 'employees.id')
            ->where('examintaion_services.treatment_id', $request->param)
            ->select('m_general_examinations.description as description', 'employees.name as name', 'examintaion_services.treatment_time as treatment_time', 'examintaion_services.examination_result as examination_result')
            ->paginate(10);
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
        // if ($this->cekAkses($request)->create == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        $validator = Validator::make($request->all(), [
            'examination_result' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        $referrer = request()->headers->get('referer');
        $jenis = explode('/', $referrer);
        // dd($jenis[4]);
        if ($jenis[4] == 'rawat-jalan-detail') {
            $jenisPerawatan = "App\Models\OutPatient";
        } else if ($jenis[4] == 'rawat-inap-detail') {
            $jenisPerawatan = "App\Models\InPatient";
        }else {
            $jenisPerawatan = "App\Models\Emergency";
        }

        $store = new ExamintaionService();
        $store->service_uuid = Str::uuid();
        $store->treatment_id = $request->param;
        $store->treatment_type = $jenisPerawatan;   
        $store->general_examination_id  = $request->general_examination_id;
        $store->examination_result     = $request->examination_result;
        $store->treatment_time         = $request->treatment_time;
        $store->officer_id             = $request->officer_id;
        // $store->superuser = $request->superuser ? 1 : 0;
        // dd($store);
        $store->save();
        // dd($store);

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
        $data = ExamintaionService::where('id', $id)->first();
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

        ExamintaionService::where('id', $id)->update([
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

        ExamintaionService::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }


    public function filter(Request $request)
    {
        $searchRequest = $request->searchQuery;
        $results = [];
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = ExamintaionService::when(!empty($search), function ($query) use ($search) {
            $query->where('amount', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        // dd($results);
        return $data;
    }
    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = ExamintaionService::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
} 