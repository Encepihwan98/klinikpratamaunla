<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuWithRole;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cekAkses($request)
    {
        $module = array();
        $joinModule = array();
        $menu = Menu::where('url', 'LIKE', '%'.$request->headers->get('referer').'%')->first();
        foreach ($request->user()->roles()->get() as $v) {
            array_push($joinModule, MenuWithRole::where('role_id', $v->role()->first()->id)->where('menu_id',$menu->id)->get());
        }
        $module = $this->compareMenu($joinModule, null, 0, 1, count($joinModule));
        return $module[0];
    }

    function compareMenu($alldata, $newData, $currentIndex, $nextIndex, $total) {
        $updateData = array();

        if($nextIndex < $total) {
            if($newData == null) {
                $index = 0;
                foreach($alldata[$currentIndex] as $data1) {
                    $data2 = $alldata[$nextIndex][$index];
                    $role = 0;
                    $menu = 0;
                    $is_home = 0;
                    $create = 0;
                    $read = 0;
                    $update = 0;
                    $delete = 0;
                    $print = 0;

                    $role = $data1->role_id.','.$data2->role_id;
                    if($data1->menu_id == $data2->menu_id) $menu = $data1->menu_id;

                    if($data1->is_home == 1) $is_home = 1;
                    if($data2->is_home == 1) $is_home = 1;

                    if($data1->create == 1) $create = 1;
                    if($data2->create == 1) $create = 1;

                    if($data1->read == 1) $read = 1;
                    if($data2->read == 1) $read = 1;

                    if($data1->update == 1) $update = 1;
                    if($data2->update == 1) $update = 1;

                    if($data1->delete == 1) $delete = 1;
                    if($data2->delete == 1) $delete = 1;

                    if($data1->print == 1) $print = 1;
                    if($data2->print == 1) $print = 1;

                    array_push($updateData, (object)["role_id" => $role,
                    "menu_id" => $menu,
                    "is_home" => $is_home,
                    "create" => $create,
                    "read" => $read,
                    "update" => $update,
                    "delete" => $delete,
                    "print" => $print]);
                    $index += 1;
                }
            } else {
                $index = 0;
                foreach($newData as $data1) {
                    $data2 = $alldata[$nextIndex][$index];
                    $role = 0;
                    $menu = 0;
                    $is_home = 0;
                    $create = 0;
                    $read = 0;
                    $update = 0;
                    $delete = 0;
                    $print = 0;

                    $role = $data1->role_id.','.$data2->role_id;
                    if($data1->menu_id == $data2->menu_id) $menu = $data1->menu_id; else dd($data2);

                    if($data1->is_home == 1) $is_home = 1;
                    if($data2->is_home == 1) $is_home = 1;

                    if($data1->create == 1) $create = 1;
                    if($data2->create == 1) $create = 1;

                    if($data1->read == 1) $read = 1;
                    if($data2->read == 1) $read = 1;

                    if($data1->update == 1) $update = 1;
                    if($data2->update == 1) $update = 1;

                    if($data1->delete == 1) $delete = 1;
                    if($data2->delete == 1) $delete = 1;

                    if($data1->print == 1) $print = 1;
                    if($data2->print == 1) $print = 1;

                    array_push($updateData, (object)["role_id" => $role,
                    "menu_id" => $menu,
                    "is_home" => $is_home,
                    "create" => $create,
                    "read" => $read,
                    "update" => $update,
                    "delete" => $delete,
                    "print" => $print]);
                    $index += 1;
                }
            }
            return $this->compareMenu($alldata, $updateData, $nextIndex, $nextIndex+1, $total);
        } else {
            if(!empty($newData)) return $newData;
            else return $alldata[0];
        }
    }
}
