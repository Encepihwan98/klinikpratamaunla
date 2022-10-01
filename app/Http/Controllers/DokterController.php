<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
            // dd($data);
        } else {
            $data = Dokter::all();
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
        // $request->validate([
        //     'sepsialis' => 'required',
        //     'no_hp' => 'required',
        //     'email' => 'required',
        //     'alamat' => 'required',
        // ]);

        $store = new Dokter();
        $store->user_id         = $request->user_id;
        $store->spesialis       = $request->spesialis;
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
        $data = Dokter::where('id', $id)->first();
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

        Dokter::where('id', $id)->update([
            'user_id' => $request->user_id,
            'spesialis' => $request->spesialis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
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
        Dokter::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Dokter::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
            ->join('users', 'dokters.user_id', '=', 'users.id')
            ->select('users.name', 'dokters.spesialis', 'dokters.alamat', 'dokters.no_hp','dokters.id')
            ->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);


        return $data;
    }

    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Dokter::join('users', 'dokters.user_id', '=', 'users.id')
                ->select('dokters.id', 'users.name')
                ->get();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
