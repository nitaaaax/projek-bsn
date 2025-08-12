<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::with('role')
            ->when($search, function ($query, $search) {
                $query->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->get();

        return view('admin.roleindex', compact('users'));
    }

    public function create() {
        $roles = Role::all(); 
        return view('admin.rolecreate', compact('roles')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username', 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'username' => $request->username, 
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.roleindex')->with('success', 'Akun Berhasil Ditambahkan.');;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Tambahan: Cegah admin hapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);

        // Tidak bisa ubah role sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Kamu tidak bisa mengubah rolenya sendiri.');
        }

        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('success', 'Role berhasil diperbarui.');
    }

    public function profile()
    {
        $user = auth()->user(); 
        return view('partial.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        // Update username dan email
        $user->username = $request->username;
        $user->email = $request->email;

        // Validasi jika password diisi
        if ($request->filled('password')) {
            // Cek apakah password baru sama dengan yang lama
            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama.'])->withInput();
            }

            // Simpan password baru
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.view')->with('success', 'Profil berhasil diperbarui.');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        
        $user->password = Hash::make('123456');
        $user->save();

        return redirect()->route('admin.roleindex')->with('success', 'Password berhasil direset ke default.');
    }
}
