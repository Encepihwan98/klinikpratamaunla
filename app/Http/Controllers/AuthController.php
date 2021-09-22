<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'errors' => ['Tolong cek kembali email dan password'],
                'status' => 'error',
                'message' => 'Login gagal!'
            ]);
        }

        return response()->json([
            'message' => 'Login sukses!',
            'status' => 'success',
            'data'=> $user->createToken($request->email)->plainTextToken], 200);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $roles = [];
        foreach ($user->roles()->get() as $value2) {
            array_push($roles, $value2->role()->first()->name);
        }
        $user->roles = $roles;

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diambil.',
            'data' => $user,
        ]);
    }

    /**
     * Logout User
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil.'
        ], 200);
    }
}
