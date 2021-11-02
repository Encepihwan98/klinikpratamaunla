<?php

namespace App\Http\Controllers;

use App\Models\RoomGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomgradeController extends Controller
{
    public function global_function(Request $request){
        if (isset($request->limit)) {
            $data = $this->filter($request);
        } else {
            $data = RoomGrade::all();
        }
        return response()->json(['data' => $data, 'message' => 'Successfully.', 'status' => 'success']);
    }
}
