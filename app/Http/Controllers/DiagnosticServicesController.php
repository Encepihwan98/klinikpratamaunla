<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class DiagnosticServicesController extends Controller
{
    public function index(Request $request)
    {
        // if ($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if (isset($request->limit)) {
            $data = $this->filter($request);
            dd($data);
        } else {
            $data = DiagnosticService::join('employees', 'diagnostic_services.officer_id', '=', 'employees.id')
            ->join('m_diseases', 'diagnostic_services.disease_id', '=', 'm_diseases.id')
            ->where('diagnostic_services.treatment_id', $request->param)
            ->select('m_diseases.description as description', 'employees.name as name','diagnostic_services.treatment_time as treatment_time', 'diagnostic_services.long_suffering as long_suffering')
            ->paginate(10);
            // dd($data);
            // $data = DiagnosticService::all();

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
            'cases' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }
        $store = new DiagnosticService();
        $store->service_uuid = Str::uuid();
        $store->disease_id = $request->disease_id;
        $store->treatment_id = 2;
        $store->treatment_type = "App\Models\DiagnosticService";
        $store->long_suffering = $request->long_suffering;
        $store->cases = $request->case_id;
        $store->diagnostic_type_id = $request->	diagnostic_type_id;
        $store->officer_id = $request->officer_id;
        $store->treatment_time = $request->diagnostic_time;
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
        $data = DiagnosticService::where('id', $id)->first();
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

        DiagnosticService::where('id', $id)->update([
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

        DiagnosticService::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }


    public function filter(Request $request)
    {
        $searchRequest = $request->searchQuery;
        $results = [];
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = DiagnosticService::when(!empty($search), function ($query) use ($search) {
            $query->where('cases', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        // dd($data);

        // foreach ($data as $value) {
        //     $post = DB::table('m_diseases')
        //         ->where('diagnostic_services.id', '=', $value['disease_id'])
        //         ->join('m_diseases', 'diagnostic_services.disease_id', '=', 'm_diseases.id')
        //         ->join('employees', 'm_diseases.officer_id', '=', 'employees.id')
        //         ->first();
        //     dd($post);
        //     if (isset($post->name)) {
        //         array_push($results, (object)['name' => $post->name, 'description' => $post->description, 'long_suffering' => $post->long_suffering, 'treatment_time' => $post->treatment_time]);
        //     }
        //     dd($post);
        // }
        // dd($results);
        return $results;
    }
    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = DiagnosticService::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
