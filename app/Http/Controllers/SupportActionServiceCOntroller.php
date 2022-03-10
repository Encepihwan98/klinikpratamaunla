<?php

namespace App\Http\Controllers;

use App\Models\SupportActionService;
use App\Models\SupportService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ServiceRate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SupportActionServiceCOntroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // if ($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if (isset($request->limit)) {
            $data = $this->filter($request);
            // dd($data);
        } else {
            $data = SupportActionService::join('m_medical_activities', 'support_action_services.action_id', '=', 'm_medical_activities.id')
                ->join('support_services', 'support_action_services.support_id', '=', 'support_services.id')
                ->join('polyclinics', 'support_services.polyclinic_id', '=', 'polyclinics.id')
                ->join('visits', 'support_services.treatment_id', '=', 'visits.id')
                ->join('patients', 'visits.patient_id', '=', 'patients.id')
                ->where('patients.id', $request->param)
                ->select(
                    'support_action_services.action_time as action_time',
                    'support_action_services.action_type as action_type',
                    'support_action_services.amount as amount',
                    'support_action_services.id as id',
                    'support_action_services.note as note',
                    'support_action_services.officer_id as officer_id',
                    'support_action_services.action_id as action_id',
                    '.m_medical_activities.description as description',
                    'support_action_services.rate as rate',
                    'patients.name as name',
                    'polyclinics.name as polyclinic'
                )
                ->paginate(100);
            $post = [];
            foreach ($data as $item) {
                $item['rate'] = json_decode($item['rate'], true);
                //   dd($item['rate']);
                array_push($post, $item);
            }
            // dd($data);
            return $data;
        }

        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function rateLaboratorium(Request $request) {
        $data = SupportActionService::join('m_medical_activities', 'support_action_services.action_id', '=', 'm_medical_activities.id')
                ->join('support_services', 'support_action_services.support_id', '=', 'support_services.id')
                ->join('polyclinics', 'support_services.polyclinic_id', '=', 'polyclinics.id')
                ->where('polyclinics.name', 'laboratorium')
                ->join('visits', 'support_services.treatment_id', '=', 'visits.id')
                ->join('patients', 'visits.patient_id', '=', 'patients.id')
                ->where('patients.id', $request->param)
                ->select(
                    'support_action_services.action_time as action_time',
                    'support_action_services.action_type as action_type',
                    'support_action_services.amount as amount',
                    'support_action_services.id as id',
                    'support_action_services.note as note',
                    'support_action_services.officer_id as officer_id',
                    'support_action_services.action_id as action_id',
                    '.m_medical_activities.description as description',
                    'support_action_services.rate as rate',
                    'patients.name as name',
                    'polyclinics.name as polyclinic'
                )
                ->paginate(10);
            $post = [];
            foreach ($data as $item) {
                $item['rate'] = json_decode($item['rate'], true);
                //   dd($item['rate']);
                array_push($post, $item);
            }
            // dd($data);
            return $data;
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

        // $referrer = request()->headers->get('referer');
        // $jenis = explode('/', $referrer);

        // if ($jenis[4] == 'rawat-inap-detail') {
        //     $jenisPerawatan = "App\Models\InPatient";
        // } else if ($jenis[4] == 'rawat-jalan-detail') {
        //     $jenisPerawatan = "App\Models\OutPatient";
        // } else {
        //     $jenisPerawatan = "App\Models\Emergency";
        // }




        // $data = ServiceRate::select('service_rate', 'id')
        //     ->where('tarifable_id', '=', $request->action_id)
        //     ->first();

        $data = DB::table('m_service_rates')
            ->where('tarifable_id', '=', $request->action_id)
            ->first();
        // dd($data);
        $post = [];
        array_push($post, json_decode($data->service_rate, true));

        // dd($post[0]['TARIF_UMUM']);

        $store = new SupportActionService();
        // $store->id = Str::id();
        $store->service_uuid    = Str::uuid();
        $store->support_id      = $request->param;
        $store->action_id       = $request->action_id;
        $store->action_type     = "App\Models\MedicalActivity";
        $store->amount          = $request->amount;
        $store->action_time     = $request->action_time;
        $store->officer_id      = $request->officer_id;
        $store->note            = $request->note;
        $store->rate            = json_encode($post[0]['TARIF_UMUM']);
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
        $data = SupportActionService::where('id', $id)->first();
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

        SupportActionService::where('id', $id)->update([
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

        SupportActionService::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }


    public function filter(Request $request)
    {
        $searchRequest = $request->searchQuery;
        $results = [];
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = SupportActionService::when(!empty($search), function ($query) use ($search) {
            $query->where('rate', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);
        // dd($request->param);
        $data = SupportActionService::join('m_medical_activities', 'support_action_services.action_id', '=', 'm_medical_activities.id')
            ->where('support_action_services.support_id', $request->param)
            ->select(
                'support_action_services.action_time as action_time',
                'support_action_services.action_type as action_type',
                'support_action_services.amount as amount',
                'support_action_services.id as id',
                'support_action_services.note as note',
                'support_action_services.officer_id as officer_id',
                'support_action_services.action_id as action_id',
                '.m_medical_activities.description as description',
                'support_action_services.rate as rate'
            )->paginate(10);
        $post = [];
        foreach ($data as $item) {
            $item['rate'] = json_decode($item['rate'], true);
            //   dd($item['rate']);
            array_push($post, $item);
        }
        // dd($data);
        return $data;
    }
    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = SupportActionService::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function getGlobal()
    {
        $data = SupportActionService::join('m_medical_activities', 'support_action_services.action_id', '=', 'm_medical_activities.id')->get();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
