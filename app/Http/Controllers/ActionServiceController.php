<?php

namespace App\Http\Controllers;

use App\Models\ActionService;
use App\Models\ServiceRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

class ActionServiceController extends Controller
{
    public function index(Request $request)
    {
        // if ($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = ActionService::join('m_examination_actions', 'action_services.examination_action_id', '=', 'm_examination_actions.id')
                ->join('employees', 'action_services.officer_id', '=', 'employees.id')
                ->where('action_services.treatment_id', $request->param)
                ->select('m_examination_actions.description as description', 'employees.name as name', 'action_services.treatment_time as treatment_time', 'action_services.amount as amount', 'action_services.rate as rate')
                ->paginate(10);
        }

        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function getRate(Request $request)
    {
        // if ($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = ActionService::join('m_examination_actions', 'action_services.examination_action_id', '=', 'm_examination_actions.id')
                ->join('employees', 'action_services.officer_id', '=', 'employees.id')
                ->where('action_services.treatment_id', $request->param)
                ->select('m_examination_actions.description as description', 'employees.name as name', 'action_services.treatment_time as treatment_time', 'action_services.amount as amount', 'action_services.rate as rate')
                ->first();

            // dd($data);


            // foreach ($data as $value) {
                $model = $data['rate'];
                // dd($model);
                if (isset($data['rate'])) {
                    $post['rate'] = json_decode($model);
                    // dd($post);
                } else {
                    // $show = $model::where('id', $value['id'])->first();
                    // $value['rate'] = $show['rate']; 
                    // $data['rate'] = json_decode($model);
                    // $post['rate'] = json_decode($model);
                    
                    $post['rate'] = json_decode($model);
                    // dd($post);
                }
            // }
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
            'amount' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        $referrer = request()->headers->get('referer');
        $jenis = explode('/', $referrer);

        if ($jenis[4] == 'rawat-inap-detail') {
            $jenisPerawatan = "App\Models\InPatient";
        } else if ($jenis[4] == 'rawat-jalan-detail') {
            $jenisPerawatan = "App\Models\OutPatient";
        } else {
            $jenisPerawatan = "App\Models\Emergency";
        }


        // $data = ServiceRate::select('tarifable_id')
        //         ->where('tarifable_id','=', $request->examination_action_id);
        //     dd($data); ->where('tarifable_id','=', $request->examination_action_id)

        $data = ServiceRate::select('service_rate', 'id')
            ->where('tarifable_id', '=', $request->examination_action_id)
            ->first();
        // dd($data);







        $store = new ActionService();
        // $store->id = Str::id();
        $store->service_uuid = Str::uuid();
        $store->treatment_id = $request->param;
        $store->treatment_type = $jenisPerawatan;
        $store->examination_action_id  = $request->examination_action_id;
        $store->amount                 = $request->amount;
        $store->treatment_time         = $request->treatment_time;
        $store->officer_id             = $request->officer_id;
        $store->rate                   = $data;
        // $store->superuser = $request->superuser ? 1 : 0;
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
        $data = ActionService::where('id', $id)->first();
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

        ActionService::where('id', $id)->update([
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

        ActionService::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }


    public function filter(Request $request)
    {
        $searchRequest = $request->searchQuery;
        $results = [];
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = ActionService::when(!empty($search), function ($query) use ($search) {
            $query->where('rate', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        $data = ActionService::join('m_examination_actions', 'action_services.examination_action_id', '=', 'm_examination_actions.id')
            ->join('employees', 'action_services.officer_id', '=', 'employees.id')
            ->where('action_services.treatment_id', $request->param)
            ->select('m_examination_actions.description as description', 'employees.name as name', 'action_services.treatment_time as treatment_time', 'action_services.amount as amount', 'action_services.rate as rate')
            ->paginate(10);

        // dd($data);
        return $data;
    }
    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = ActionService::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
