<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suplier;

class SuplierController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Suplier::all();
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
        $store = new Suplier();
        $store->nama = $request->nama;
        $store->no_hp = $request->no_hp;
        $store->email = $request->email;
        $store->alamat = $request->alamat;
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
        $data = Suplier::where('id', $id)->first();
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
        $data = Suplier::where('id', $id)->update([
            'nama' => $request->nama,
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
        Suplier::where('id', $id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Suplier::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function global_function(Request $request)
    {
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Suplier::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
