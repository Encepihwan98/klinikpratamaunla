<?php

namespace App\Http\Controllers;

use App\Models\ServiceRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    public function index(Request $request)
    {
        if ($this->cekAkses($request)->read == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        }

        if (isset($request->limit)) {
            $data = $this->filter($request);
            // dd($data);
        } else {
            $data = ServiceRate::all();
            // dd($data);
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
        if ($this->cekAkses($request)->create == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|unique:m_roles',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }
        $store = new ServiceRate();
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
        $data = ServiceRate::where('id', $id)->first();
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
            'service_rate' => 'nullable|unique:m_roles',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        ServiceRate::where('id', $id)->update([
            'service_rate' => $request->data,
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
        if ($this->cekAkses($request)->delete == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        }

        if ($id == null) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus!', 'errors' => 'ID kosong']);
        }

        ServiceRate::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function tarifKeungan(Request $request){
        $data = ServiceRate::all();
        // dd($data);
        if (isset($request->select) && $request->select == 'all'){
            foreach ($data as $value) {
                if(isset ($value['service_type'])) {
                    $type = explode("\\", $value['service_type']);
                    $model = $value['service_type'];
                        if($type[2] == 'dd'){
                            
                        }
                    // dd($type);
                }
            }
        }
    }


    public function filter(Request $request)
    {
        $results = [];
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $result = ServiceRate::when(!empty($search), function ($query) use ($search) {
            $query->where('service_rate', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        if (isset($request->select) && $request->select == 'all') {
            foreach ($result as $value) {
                if (isset($value['service_type'])) {
                    $type = explode("\\", $value['service_type']);
                    $model = $value['service_type'];
                        if($type[2] == 'PolyclinicRoom'){
                            $post = DB::table('m_service_rates')
                            ->where('m_service_rates.tarifable_id', $value['tarifable_id'])
                            ->join('polyclinic_rooms','m_service_rates.tarifable_id', '=','polyclinic_rooms.id')
                            ->join('polyclinics', 'polyclinic_rooms.polyclinic_id','=','polyclinics.id' )
                            ->select('polyclinics.name as polyclinics','polyclinic_rooms.name as room','polyclinic_rooms.type')
                            ->first();
                            $value['service_name'] = $post;
                            // dd($post);   
                            
                        }else{
                            $show = $model::where('id', $value['tarifable_id'])->first();
                            $value['service_name'] = $show['description'];
                            // dd($value['service_name']);
                        }
                    if (isset($results[$type[2]])) {
                        $results[$type[2]]['total'] += 1;
                        $results[$type[2]]['lastPage'] = $results[$type[2]]['total'] > $result->perPage() ? $results[$type[2]]['total'] / $result->perPage() : 1;
                        array_push($results[$type[2]]['data'], $value);
                    } else {
                        $results[$type[2]]['total'] = 1;
                        $results[$type[2]]['lastPage'] = $result->lastPage();
                        $results[$type[2]]['data'] = [$value];
                    }
                }
                $results[$type[2]]['perPage'] = $result->perPage();
                $results[$type[2]]['currentPage'] = $result->currentPage();
                $results[$type[2]]['path'] = $result->path();
                // $results['query'] = $result->getPageName();
                $results[$type[2]]['fragment'] = $result->fragment();
                $results[$type[2]]['pageName'] = $result->getPageName();
                $results[$type[2]]['options'] = $result->getOptions();
            }
        } else if (isset($request->select)) {
            foreach ($result as $value) {
                if (isset($value['service_type'])) {
                    $type = explode("\\", $value['service_type']);
                    if ($type[2] == $request->select) {
                        $object = [$value];
                        if (isset($results[$type[2]])) {
                            $results[$type[2]]['total'] += 1;
                            $results[$type[2]]['lastPage'] = $results[$type[2]]['total'] > $result->perPage() ? $results[$type[2]]['total'] / $result->perPage() : 1;
                            array_push($results[$type[2]]['data'], $object);
                            // dd($object);
                        } else {
                            $results[$type[2]]['total'] = 1;
                            $results[$type[2]]['lastPage'] = $result->lastPage();
                            $results[$type[2]]['data'] = $object;
                        }
                        $results[$type[2]]['perPage'] = $result->perPage();
                        $results[$type[2]]['currentPage'] = $result->currentPage();
                        $results[$type[2]]['path'] = $result->path();
                        // $results['query'] = $result->getPageName();
                        $results[$type[2]]['fragment'] = $result->fragment();
                        $results[$type[2]]['pageName'] = $result->getPageName();
                        $results[$type[2]]['options'] = $result->getOptions();
                    }
                }
            }
        }

        return (object)$results;
    }


    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = ServiceRate::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
