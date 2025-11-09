<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Hash;
use Illuminate\Http\Request;

class RoleController extends Controller {
    public function index() {
        $datas = Role::all();

        return view('pages.roles.index', compact('datas'));
    }
    public function create() {
        
        return view('pages.roles.create');
    }
    public function edit(string $id) {
        $datas = Role::find($id);
        return view('pages.roles.create', compact('datas'));
    }
    public function search (Request $request) {
        $q = request()->query('q');

        $datas = Role::select('id', 'name', 'created_at');
        if ( $q != '')  { 

            $datas->where(function ($query) use ($q) {
                $query
                ->where('name','like','%'. $q .'%')
                ->orWhere('created_at','like','%'. $q .'%');
            });
        }

    $datas = $datas->get();

        $html = view('partials.RolesTableBody', compact('datas', 'q'))->render();

        return response()->json(['html' => $html]);
    }
    public function store (Request $request) {
        $validate = $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);
        
        try {
            Role::create([
                'name' => $validate['name'],
            ]);
                
            return redirect()->route('roles.index')
                ->with('floatingAlert', [
                    'title' => 'Success', 
                    'type' => 'success', 
                    'message' => 'Berhasil menambah Role baru'
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->withInput()->with('floatingAlert', ['title' => 'Failed', 'type' => 'error', 'message' => 'Gagal menambah Role baru']);
        }
    }
    public function update (Request $request, string $id) {

        try {
            $data = $request->validate([
                'name' => 'required|string|unique:roles,name|max:255',
            ]);

            Role::where('id',$id)->update($data);
                
            return redirect()->route('roles.index')
                ->with('floatingAlert', [
                    'title' => 'Update Role Success', 
                    'type' => 'success', 
                    'message' => ""
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->withInput()->with('floatingAlert', ['title' => 'Gagal Update Role', 'type' => 'error', 'message' => ""]);
        }
    }
    public function destroys (Request $request) {
        try {
            $ids = $request->query('id');
            Role::destroy( $ids );
            $count = count($ids);
            return redirect()->route('roles.index')
                ->with('floatingAlert', ['title' => "Berhasil Hapus $count Role", 'type' => 'success', 'message' => ""]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('floatingAlert', ['title' => 'Gagal Hapus Role', 'type' => 'error', 'message' => ""]);
        }
    }
}