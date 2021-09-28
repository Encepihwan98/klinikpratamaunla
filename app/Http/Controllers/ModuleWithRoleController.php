<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuWithRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Auth;

class ModuleWithRoleController extends Controller
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

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diambil!', 'data' => $this->filter($request)]);
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

        $roleId = Role::where('name', $request->role)->first();
        $menuId = 0;
        $status = 0;
        if(isset($request->state) && $request->state != 'is_all') {
            $create = $request->create;
            $read = $request->read;
            $update = $request->update;
            $delete = $request->delete;
            $print = $request->print;
            if($request->state == 'create') {
                $menuId = $create['id'];
                $status = $create['status'];
                MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $create['id'])->update([$request->state => $create['status']]);
            }
            if($request->state == 'read') {
                $menuId = $read['id'];
                $status = $read['status'];
                MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $read['id'])->update([$request->state => $read['status']]);
            }
            if($request->state == 'update') {
                $menuId = $update['id'];
                $status = $update['status'];
                MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $update['id'])->update([$request->state => $update['status']]);
            }
            if($request->state == 'delete') {
                $menuId = $delete['id'];
                $status = $delete['status'];
                MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $delete['id'])->update([$request->state => $delete['status']]);
            }
            if($request->state == 'print') {
                $menuId = $print['id'];
                $status = $print['status'];
                MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $print['id'])->update([$request->state => $print['status']]);
            }
            if($request->state == 'is_home') {
                MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $request->is_home_old)->update(['is_home' => 0]);
                MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $request->is_home)->update(['is_home' => 1]);
            }
        } else {
            $menuId = $request->id;
            $status = !$request->status;
            MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $request->id)->update(['create' => !$request->status, 'read' => !$request->status, 'update' => !$request->status, 'delete' => !$request->status, 'print' => !$request->status]);
        }
        if($request->state != 'is_home') {
            $newStatus = $status;
            $parent = Menu::find($menuId);
            if($status == false) {
                foreach (Menu::where('parent_id', $parent->parent_id)->get() as $key => $value) {
                    $read = MenuWithRole::where('role_id', $roleId->id)->where('menu_id', $value->id)->first();
                    if($read->read == 1) $newStatus = true;
                }
            }
            MenuWithRole::where('menu_id', $parent->parent_id)->update(['read' => $newStatus]);
        }

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diubah!', 'data' => $this->filter($request)]);
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

    public function filter(Request $request)
    {
        $module = array();
        $compareModule = array();
        $fixModule = array();
        if(isset($request->role) && !empty($request->role) && $request->role != 'undefined') {
            $roleId = Role::where('name', $request->role)->first();
            $compareModule = MenuWithRole::where('role_id', $roleId->id)->orderBy('menu_id', 'asc')->get();
        } else {
            foreach ($request->user()->roles()->get() as $v) {
                array_push($module, MenuWithRole::where('role_id', $v->role()->first()->id)->orderBy('menu_id', 'asc')->get());
            }
            $compareModule = $this->compareMenu($module, null, 0, 1, count($module));
        }
        foreach ($compareModule as $key => $value) {
            $custom = collect($value);
            $menu = Menu::find($value->menu_id);
            if($menu->url != '#') {
                $customModule = $custom->merge($menu);
                array_push($fixModule, $customModule);
            }
        }

        return $fixModule;
    }
}
