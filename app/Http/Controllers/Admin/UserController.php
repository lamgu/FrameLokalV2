<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withCount('reviews')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        // Prevent admin from changing their own role to 'user' to avoid locking themselves out
        if ($user->id === Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
