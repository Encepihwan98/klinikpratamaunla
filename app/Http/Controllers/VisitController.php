<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        // if ($this->cekAkses($request)->read == 0) {
        //     return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status' => 'error'], 403);
        // }

        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Visit::all();
            
        }

        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }

    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $results = [];
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Visit::when(!empty($search), function ($query) use ($search) {
            $query->where('visit_number', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        // foreach($data as $value){
        //     $post = DB::table('visits')
        //     ->join('patients','visits.patient_id','=','patients.id')
        //     ->first();
        //     // dd($post);
        //     if (isset($post->name)){
        //         array_push($results, (object)['name' => $post->name, 'id' => $post->id, 'visit_number' => $post->visit_number, 'visit_out' => $post->visit_out]);
        //     }
        //     // dd($post);
        // }
       
        $data = Visit::join('patients','visits.patient_id','=','patients.id')
            ->select('visits.visit_number as visit_number','patients.name as name', 'visits.visit_out as visit_out','visits.id')
            ->paginate(10);

        return $data;
    }

}
