<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuWithRole;
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
    public function index(Request $request)
    {
        if($this->cekAkses($request)->read == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        if(isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = Role::all();
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
            'name' => 'required|unique:m_roles',
            'description' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }
        $store = new Role();
        $store->uuid = Str::uuid();
        $store->name = $request->name;
        $store->description = $request->description;
        $store->superuser = $request->superuser ? 1 : 0;
        $store->save();

        $count = MenuWithRole::where('role_id', $store->id)->count();
        if($count == 0) {
            foreach (Menu::all() as $key => $value) {
                $store_role_menu = new MenuWithRole();
                $store_role_menu->role_id = $store->id;
                $store_role_menu->menu_id = $value->id;
                $store_role_menu->is_home = 0;
                $store_role_menu->create = 0;
                $store_role_menu->read = 0;
                $store_role_menu->update = 0;
                $store_role_menu->delete = 0;
                $store_role_menu->print = 0;
                $store_role_menu->save();
            }
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
        $data = Role::where('uuid',$id)->first();
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

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|unique:m_roles',
            'description' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        Role::where('uuid', $id)->update([
            'name' => $request->name,
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
        if($this->cekAkses($request)->delete == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        if ($id == null) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus!', 'errors' => 'ID kosong']);
        }
        $role = Role::where('uuid', $id);
        MenuWithRole::where('role_id', $role->first()->id)->delete();
        $role->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $data = Role::when(!empty($search), function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->orderBy($request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        return $data;
    }
}
