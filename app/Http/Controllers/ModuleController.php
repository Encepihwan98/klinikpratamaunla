<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuWithRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:m_menus',
            'slug' => 'required|unique:m_menus',
            'icon' => 'nullable',
            'component' => 'required',
            'url' => 'required',
            'parent' => 'required',
            'mustLogin' => 'required',
            'order' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        $store = new Menu();
        $store->uuid = Str::uuid();
        $store->name = $request->name;
        $store->slug = $request->slug;
        $store->url = $request->url;
        $store->parent_id = $request->parent == 'Root' ? 0 : Menu::where('name', $request->parent)->first()->id;
        $store->order = $request->order;
        $store->icon = $request->order;
        $store->component = $request->component;
        $store->mustLogin = $request->mustLogin == 'Ya' ? true : false;
        $store->save();

        $role = Role::all();

        foreach ($role as $key => $value) {
            $storeMenuWithRole = new MenuWithRole();
            $storeMenuWithRole->role_id = $value->id;
            $storeMenuWithRole->menu_id = $store->id;
            $storeMenuWithRole->is_home = 0;
            $storeMenuWithRole->create = 0;
            $storeMenuWithRole->read = 0;
            $storeMenuWithRole->update = 0;
            $storeMenuWithRole->delete = 0;
            $storeMenuWithRole->print = 0;
            $storeMenuWithRole->save();
        }

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Menu::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }
}
