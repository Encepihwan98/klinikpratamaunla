<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apoteker;
use Illuminate\Support\Facades\DB;

class ApotekerController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
            // dd($data);
        } else {
            $data = Apoteker::all();
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
        // $request->validate([
        //     'sepsialis' => 'required',
        //     'no_hp' => 'required',
        //     'email' => 'required',
        //     'alamat' => 'required',
        // ]);

        $store = new Apoteker();
        $store->user_id         = $request->user_id;
        
        $store->jenis_kelamin   = $request->jenis_kelamin;
        $store->no_hp           = $request->no_hp;
        $store->email           = $request->email;
        $store->alamat          = $request->alamat;
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
        $data = Apoteker::where('id', $id)->first();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
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
        // $request->validate([
        //     'user_id' => 'required',
        //     'spesialis' => 'required',
        //     'jenis_kelamin' => 'required',
        //     'no_hp' => 'required',
        //     'alamat' => 'required',

        // ]);

        Apoteker::where('id', $id)->update([
            'user_id' => $request->user_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
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
        Apoteker::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Apoteker::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);
        // foreach ($data as $value) {
        //     $results = DB::table('apotekers')
        //         ->join('users', 'apotekers.user_id', '=', 'users.id')
        //         ->select('users.name',  'apotekers.alamat', 'apotekers.no_hp')
        //         ->paginate(10);
        // }


        return $data;
    }
}
