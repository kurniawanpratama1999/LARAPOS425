<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::with('role')->get();
        return view('pages.users.index', compact('datas'));
    }
    public function create()
    {

        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
    }
    public function edit(string $id)
    {
        $datas = User::with('role')->find($id);
        $roles = Role::all();
        return view('pages.users.create', compact('datas', 'roles'));
    }
    public function search(Request $request)
    {
        $q = request()->query('q');

        $datas = User::with('role')->makeHidden('password');
        if ($q != '') {

            $datas->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%')
                    ->orWhere('role_id', 'like', '%' . $q . '%')
                    ->orWhere('created_at', 'like', '%' . $q . '%');
            });
        }

        $datas = $datas->get();

        $html = view('partials.UsersTableBody', compact('datas', 'q'))->render();

        return response()->json(['html' => $html]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|integer|exists:roles,id',
            'password' => 'required|string|min:8',
            'confirm-password' => 'same:password',
        ]);

        try {
            User::create([
                'name' => $validate['name'],
                'email' => $validate['email'],
                'photo_profile' => null,
                'role_id' => $validate['role_id'],
                'password' => Hash::make($validate['password']),
            ]);

            return redirect()->route('users.index')
                ->with('floatingAlert', [
                    'title' => 'Success',
                    'type' => 'success',
                    'message' => 'Berhasil menambah user baru'
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->withInput($request->except('password'))->with('floatingAlert', ['title' => 'Failed', 'type' => 'error', 'message' => 'Gagal menambah user baru']);
        }
    }
    public function update(Request $request, string $id)
    {

        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required|integer|exists:roles,id',
                'status' => 'required|integer',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            if (!empty($data['[password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            User::where('id', $id)->update($data);

            return redirect()->route('users.index')
                ->with('floatingAlert', [
                    'title' => 'Update User Success',
                    'type' => 'success',
                    'message' => ""
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->withInput($request->except('password'))->with('floatingAlert', ['title' => 'Gagal Update User', 'type' => 'error', 'message' => ""]);
        }
    }
    public function destroys(Request $request)
    {
        try {
            $ids = $request->query('id');
            User::destroy($ids);
            $count = count($ids);
            return redirect()->route('users.index')
                ->with('floatingAlert', ['title' => "Berhasil Hapus $count User", 'type' => 'success', 'message' => ""]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('floatingAlert', ['title' => 'Gagal Hapus User', 'type' => 'error', 'message' => ""]);
        }
    }
}
