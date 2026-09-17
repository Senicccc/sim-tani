<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'data' => User::query()->orderBy('nama_lengkap')->get(),
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'data' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_anggota' => ['required', 'string', 'unique:users,nomor_anggota'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            'nomor_wa' => ['nullable', 'string', 'max:20', 'unique:users,nomor_wa'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'anggota'])],
            'status_aktif' => ['sometimes', 'boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status_aktif'] = $validated['status_aktif'] ?? true;

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data' => $user,
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nomor_anggota' => ['sometimes', 'string', Rule::unique('users', 'nomor_anggota')->ignore($user->id)],
            'nama_lengkap' => ['sometimes', 'string', 'max:255'],
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'nomor_wa' => ['nullable', 'string', 'max:20', Rule::unique('users', 'nomor_wa')->ignore($user->id)],
            'password' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', Rule::in(['admin', 'anggota'])],
            'status_aktif' => ['sometimes', 'boolean'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->fill($validated);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => $user->fresh(),
        ]);
    }

    public function destroy(User $user)
    {
        $user->update(['status_aktif' => false]);

        return response()->json([
            'success' => true,
            'message' => 'User deactivated successfully.',
            'data' => null,
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully.',
            'data' => $request->user()->load('competencies.jobType'),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama_lengkap' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'nomor_wa' => ['sometimes', 'nullable', 'string', 'max:20', Rule::unique('users', 'nomor_wa')->ignore($user->id)],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'foto' => ['sometimes', 'nullable', 'string'],
        ]);

        if (array_key_exists('password', $validated) && $validated['password'] !== null) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->fill($validated);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => $user->fresh(),
        ]);
    }
}
