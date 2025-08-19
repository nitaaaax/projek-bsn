<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        try {
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Akun berhasil ditambahkan'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Gagal menambahkan akun: ' . $e->getMessage()
                ]
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            
            if (auth()->id() == $user->id) {
                return redirect()->back()->with([
                    'toastr' => [
                        'type' => 'error',
                        'title' => 'Gagal',
                        'message' => 'Anda tidak bisa menghapus akun sendiri'
                    ]
                ]);
            }

            $user->delete();
            DB::commit();

            return redirect()->route('admin.users.index')->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Akun berhasil dihapus'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Gagal menghapus akun: ' . $e->getMessage()
                ]
            ]);
        }
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            if ($user->id === auth()->id()) {
                return redirect()->back()->with([
                    'toastr' => [
                        'type' => 'error',
                        'title' => 'Gagal',
                        'message' => 'Anda tidak bisa mengubah role sendiri'
                    ]
                ]);
            }

            $user->role_id = $request->role_id;
            $user->save();
            DB::commit();

            return redirect()->back()->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Role berhasil diperbarui'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Gagal mengupdate role: ' . $e->getMessage()
                ]
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        DB::beginTransaction();

        try {
            $user->username = $request->username;
            $user->email = $request->email;

            if ($request->filled('password')) {
                if (Hash::check($request->password, $user->password)) {
                    return back()->withInput()->with([
                        'toastr' => [
                            'type' => 'error',
                            'title' => 'Gagal',
                            'message' => 'Password baru tidak boleh sama dengan password lama'
                        ]
                    ]);
                }
                $user->password = Hash::make($request->password);
            }

            $user->save();
            DB::commit();

            return redirect()->route('profile.view')->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Profil berhasil diperbarui'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Gagal mengupdate profil: ' . $e->getMessage()
                ]
            ]);
        }
    }

    public function resetPassword($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->password = Hash::make('123456');
            $user->save();
            DB::commit();

            return redirect()->route('admin.users.index')->with([
                'toastr' => [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => 'Password berhasil direset ke default'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Gagal mereset password: ' . $e->getMessage()
                ]
            ]);
        }
    }
}
