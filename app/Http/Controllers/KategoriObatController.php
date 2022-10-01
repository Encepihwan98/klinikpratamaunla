<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriObat;

class KategoriObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->limit)){
            $data = $this->filter($request);
        }else{
            $data = KategoriObat::all();
        }

        return response()->json(['data' => $data,'message' => 'Successfully.', 'status'=>'success']);
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
        $request->validate([
            'kategori' => 'required',
        ]);

        $store = new KategoriObat();
        $store->kategori = $request->kategori;
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
        $data = KategoriObat::where('id', $id)->first();
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status'=>'success']);
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
        $request->validate([
            'kategori' => 'required',
        ]);

        KategoriObat::where('id', $id)->update([
            'kategori' => $request->kategori,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        KategoriObat::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);

    }

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();

        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = KategoriObat::when(!empty($search), function ($query) use ($search) {
            $query->where('kategori', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }

    public function global_function(Request $request){
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = KategoriObat::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
