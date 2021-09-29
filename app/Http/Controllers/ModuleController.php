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
    public function index(Request $request)
    {
        if($this->cekAkses($request)->read == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        if(isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = $this->getParentData(Menu::all());
        }

        return response()->json(['data' => $data,'message' => 'Successfully.', 'status'=>'success']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->cekAkses($request)->create == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:m_menus',
            'slug' => 'required_if:isParent,0|unique:m_menus',
            'icon' => 'nullable',
            'component' => 'required_if:isParent,0',
            'url' => 'required_if:isParent,0',
            'parent' => 'required',
            'mustLogin' => 'required',
            'order' => 'nullable',
            'api_module' => 'nullable',
            'isParent' => 'boolean',
            'isActive' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        $store = new Menu();
        $store->uuid = Str::uuid();
        $store->name = $request->name;
        $store->slug = empty($request->slug) ? '#' : $request->slug;
        $store->url = empty($request->url) ? '#' : $request->url;
        $store->parent_id = $request->parent == 'Root' ? 0 : Menu::where('name', $request->parent)->first()->id;
        $store->order = $request->order;
        $store->icon = $request->icon;
        $store->api_module = $request->api_module;
        $store->component = empty($request->component) ? '.'  : $request->component;
        $store->must_login = $request->mustLogin == 'Ya' ? true : false;
        $store->is_active = $request->isActive == 'Aktif' ? true : false;
        $store->is_parent = empty($request->isParent) ? false : true;
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
        $data = $this->getParentData(Menu::where('uuid',$id)->first());
        return response()->json(['data' => $data,'message' => 'Successfully.', 'status'=>'success']);
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
        if($this->cekAkses($request)->update == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        $slug = $request->slug;
        $count = Menu::where('slug', $slug)->where('uuid', $id)->count();
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|unique:m_menus',
            'icon' => 'nullable',
            'component' => 'required_if:isParent,0',
            'slug' => ($count == 1) ? 'exclude' : 'nullable|unique:m_menus',
            'url' => 'nullable',
            'parent' => 'required',
            'mustLogin' => 'required',
            'order' => 'nullable',
            'api_module' => 'nullable',
            'isParent' => 'boolean',
            'isActive' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        Menu::where('uuid', $id)->update([
            'name' => $request->name,
            'slug' => empty($request->slug) ? '#' : $request->slug,
            'url' => empty($request->url) ? '#' : $request->url,
            'parent_id' => $request->parent == 'Root' ? 0 : Menu::where('name', $request->parent)->first()->id,
            'order' => $request->order,
            'icon' => $request->icon,
            'api_module' => $request->api_module,
            'component' => empty($request->component) ? '.'  : $request->component,
            'must_login' => $request->mustLogin == 'Ya' ? true : false,
            'is_active' => $request->isActive == 'Aktif' ? true : false,
            'is_parent' => empty($request->isParent) ? false : true
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
        if($this->cekAkses($request)->delete == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        if (empty($id)) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus!', 'errors' => 'ID kosong']);
        }
        $data = Menu::where('uuid', $id);
        MenuWithRole::where('menu_id', $data->first()->id)->delete();
        $data->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function myModule(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();
        foreach ($request->user()->roles()->get() as $v) {
            array_push($module, MenuWithRole::where('role_id', $v->role()->first()->id)->orderBy('menu_id', 'asc')->get());
        }
        $compareModule = $this->compareMenu($module, null, 0, 1, count($module));

        foreach ($compareModule as $key => $value) {
            if($value->read != 0) {
                $custom = collect($value);
                $customModule = $custom->merge(Menu::find($value->menu_id));
                array_push($fixModule, $customModule);
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Data berhasil diambil!', 'data' => $fixModule]);
    }

    public function getParentData($data)
    {
        $parentName = array('Root');
        $parentData = array();
        if(!is_countable($data)) {
            $data->parent = ($data->parent_id == 0) ? 'Root' :  Menu::where('id', $data->parent_id)->first()->name;
        } else {

            foreach ($data as $key => $value) {
                $data[$key]->parent = ($value->parent_id == 0) ? 'Root' : Menu::where('id',$value->parent_id)->first()->name;
            }


            array_push($parentData, (object)['name'=> 'Root', 'count'=> Menu::where('parent_id', 0)->count()]);
            foreach (Menu::all() as $key => $value) {
                if($value->url == '#') {
                    array_push($parentName, $value->name);
                    array_push($parentData, (object)['name'=> $value->name, 'count'=> Menu::where('parent_id', $value->id)->count()]);
                }
            }
        }

        $custom = collect(['parentName' => $parentName, 'parentData' => $parentData]);
        $results = $custom->merge($data);

        return $results;
    }

    public function active(Request $request, $id)
    {
        if($this->cekAkses($request)->update == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        if (empty($id)) {
            return response()->json(['status' => 'error', 'message' => 'Menu gagal diaktifkan!', 'errors' => 'ID kosong']);
        }

        Menu::where('uuid', $id)->update(['is_active' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Menu berhasil di'.($request->status ? '' : 'non').'aktifkan!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Menu::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);


        return $this->getParentData($data);
    }

}
