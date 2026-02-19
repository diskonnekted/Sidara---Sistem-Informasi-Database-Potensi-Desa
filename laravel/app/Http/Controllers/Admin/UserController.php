<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Potential;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('village')->orderByDesc('id')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $villages = Village::orderBy('village_name')->get();
        $roles = [
            'admin' => 'Admin',
            'village_admin' => 'Admin Desa',
            'owner' => 'Pemilik Potensi',
        ];

        return view('admin.users.create', [
            'user' => new User(),
            'villages' => $villages,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,village_admin,owner',
            'village_id' => 'nullable|exists:villages,id',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            if ($file && $file->isValid()) {
                $avatarPath = $file->store('avatars', 'public');
            }
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'village_id' => $data['village_id'] ?? null,
            'avatar_path' => $avatarPath,
            'is_admin' => $data['role'] === 'admin',
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Pengguna berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $villages = Village::orderBy('village_name')->get();
        $roles = [
            'admin' => 'Admin',
            'village_admin' => 'Admin Desa',
            'owner' => 'Pemilik Potensi',
        ];

        return view('admin.users.edit', [
            'user' => $user,
            'villages' => $villages,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,village_admin,owner',
            'village_id' => 'nullable|exists:villages,id',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ]);

        $avatarPath = $user->avatar_path;

        if ($request->boolean('remove_avatar') && $avatarPath && !filter_var($avatarPath, FILTER_VALIDATE_URL)) {
            $filePath = storage_path('app/public/' . $avatarPath);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $avatarPath = null;
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            if ($file && $file->isValid()) {
                if ($avatarPath && !filter_var($avatarPath, FILTER_VALIDATE_URL)) {
                    $filePath = storage_path('app/public/' . $avatarPath);

                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $avatarPath = $file->store('avatars', 'public');
            }
        }

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'village_id' => $data['village_id'] ?? null,
            'avatar_path' => $avatarPath,
            'is_admin' => $data['role'] === 'admin',
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $avatarPath = $user->avatar_path;

        if ($avatarPath && !filter_var($avatarPath, FILTER_VALIDATE_URL)) {
            $filePath = storage_path('app/public/' . $avatarPath);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Pengguna berhasil dihapus.');
    }
}
