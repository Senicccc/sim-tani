<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $identifier = $request->input('identifier');
        $password = $request->input('password');

        $user = User::where('email', $identifier)
            ->orWhere('nomor_anggota', $identifier)
            ->orWhere('nomor_wa', $identifier)
            ->first();

        if (! $user || ! Hash::check($password, $user->password) || ! $user->status_aktif) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials or inactive account.',
            ], 401);
        }

        $token = $user->createToken('simtani-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data' => [
                'user' => $user->only(['id','nomor_anggota','nama_lengkap','email','nomor_wa','role','status_aktif']),
                'token' => $token,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
            'data' => null,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Authenticated user retrieved successfully.',
            'data' => $request->user()->load('competencies.jobType'),
        ]);
    }
}
