<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleWithUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
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
            $data = User::all();

            foreach ($data as $key1 => $value1) {
                $roles = [];
                foreach ($value1->roles()->get() as $value2) {
                    array_push($roles, $value2->role()->first()->name);
                }
                $data[$key1]->roles = $roles;
            }

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
            'name' => 'required',
            'username' => 'required|unique:users',
            'address' => 'required',
            'phone' => 'required|unique:users',
            // 'email' => 'required|unique:users|email:rfc,dns',
            'password' => 'required|min:6|confirmed',
            'status' => 'required',
            'roles' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        $store = new User();
        $store->uuid = Str::uuid();
        $store->name = $request->name;
        $store->username = $request->username;
        $store->address = $request->address;
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->password = bcrypt($request->password);
        $store->status = $request->status == 'aktif' ? true : false;
        $store->save();

        foreach ($request->roles as $value) {
            $role = Role::where('name', $value)->get()[0];
            $store_role = new RoleWithUser();
            $store_role->role_id = $role->id;
            $store_role->user_id = $store->id;
            $store_role->save();
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
        $data = User::where('uuid',$id)->first();
        $roles = [];
        foreach ($data->roles()->get() as $key => $value) {
            array_push($roles, $value->role()->first()->name);
        }
        $data->roles = $roles;
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
            'name' => 'required',
            'username' => 'nullable|unique:users',
            'address' => 'required',
            'phone' => 'nullable|unique:users',
            'email' => 'nullable|unique:users|email:rfc,dns',
            'password' => 'nullable|min:6|confirmed',
            'status' => 'required',
            'roles' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status' => 'error', 'message' => 'Tolong pastikan semua sesuai dengan ketentuan!'], 400);
        }

        $update = User::where('uuid', $id);
        $currentData = $update->first();
        $update->update([
            'name' => $request->name,
            'username' => (empty($request->username)) ? $currentData->username : $request->username,
            'address' => $request->address,
            'phone' => (empty($request->phone)) ? $currentData->phone : $request->phone,
            'email' => (empty($request->email)) ? $currentData->email : $request->email,
            'password' => (empty($request->password)) ? $currentData->password : bcrypt($request->password),
            'status' => $request->status == 'aktif' ? true : false,
        ]);

        RoleWithUser::where('user_id',$request->id)->delete();

        foreach ($request->roles as $value) {
            $role = Role::where('name', $value)->get()[0];
            $store_role = new RoleWithUser();
            $store_role->role_id = $role->id;
            $store_role->user_id = $request->id;
            $store_role->save();
        }

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
        $data = User::where('uuid', $id);
        RoleWithUser::where('user_id', $data->first()->id)->delete();
        $data->delete();

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!', 'data' => $this->filter($request)]);
    }

    public function active(Request $request, $id)
    {
        if($this->cekAkses($request)->update == 0) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke module ini.', 'status'=>'error'], 403);
        }

        if (empty($id)) {
            return response()->json(['status' => 'error', 'message' => 'User gagal diaktifkan!', 'errors' => 'ID kosong']);
        }

        $data = User::where('uuid', $id)->update(['status' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'User berhasil di'.($request->status ? '' : 'non').'aktifkan!', 'data' => $this->filter($request)]);
    }

    public function filter(Request $request) {
        $searchRequest = $request->searchQuery;
        $search = !empty($searchRequest) && $searchRequest != "null" ? $searchRequest : "";
        $filterRole = [];
        if(!empty($request->role) && $request->role != "null") {
            $rolesFromRequest = explode(',',$request->role);
            foreach ($rolesFromRequest as $key => $value) {
                array_push($filterRole, Role::where('name', $value)->first());
            }
        }
        $data = User::when(!empty($request->role), function ($query) use($filterRole) {
            if(!empty($filterRole) && $query->first()->roles()->count() > 0 && $filterRole != "null") {
                foreach ($filterRole as $value) {
                    return $query->join('role_with_users as rwu', 'rwu.user_id', '=', 'users.id')
                    ->where('rwu.role_id', $value->id)
                    ->join('m_roles as role', 'role.id', '=', 'rwu.role_id')->select('role.name as role_name', 'users.*');
                }
            }
        })->when(!empty($search), function ($query) use ($search) {
            return $query->where('users.name', 'LIKE', '%' . $search . '%');
        })
        // ->toSql();
        ->orderBy('users.'.$request->sortBy, $request->orderBy)->paginate($request->limit != "" ? $request->limit : 10);

        foreach ($data as $key1 => $value1) {
            $roles = [];
            foreach ($value1->roles()->get() as $value2) {
                array_push($roles, $value2->role()->first()->name);
            }
            $data[$key1]->roles = $roles;
        }

        return $data;
    }

    public function global_function(Request $request){
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = User::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
