<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Role::paginate(10);
        return response()->json(['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable'
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $store = new Role();
        $store->uuid = Str::uuid();
        $store->name = $request->name;
        $store->description = $request->description;
        $store->superuser = $request->superuser ? 1 : 0;
        $store->save();

        return response()->json(['data' => Role::paginate(10)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable'
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Role::where('uuid', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['data' => Role::paginate(10)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == null) {
            return response()->json(['errors' => 'ID kosong']);
        }

        Role::where('uuid', $id)->delete();

        return response()->json(['data' => Role::paginate(10)]);
    }
}
