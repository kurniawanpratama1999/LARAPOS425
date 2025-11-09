<?php
namespace App\Http\Controllers;

use App\Models\Categories;
use Hash;
use Illuminate\Http\Request;

class CategoriesController extends Controller {
    public function index() {
        $datas = Categories::all();

        return view('pages.categories.index', compact('datas'));
    }
    public function create() {
        
        return view('pages.categories.create');
    }
    public function edit(string $id) {
        $datas = Categories::find($id);
        return view('pages.categories.create', compact('datas'));
    }
    public function search (Request $request) {
        $q = request()->query('q');

        $datas = Categories::select('id', 'name', 'created_at');
        if ( $q != '')  { 

            $datas->where(function ($query) use ($q) {
                $query
                ->where('name','like','%'. $q .'%')
                ->orWhere('created_at','like','%'. $q .'%');
            });
        }

    $datas = $datas->get();

        $html = view('partials.CategoriesTableBody', compact('datas', 'q'))->render();

        return response()->json(['html' => $html]);
    }
    public function store (Request $request) {
        $validate = $request->validate([
            'name' => 'required|string|unique:Categories,name|max:255',
        ]);
        
        try {
            Categories::create([
                'name' => $validate['name'],
            ]);
                
            return redirect()->route('categories.index')
                ->with('floatingAlert', [
                    'title' => 'Success', 
                    'type' => 'success', 
                    'message' => 'Berhasil menambah Categories baru'
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->withInput()->with('floatingAlert', ['title' => 'Failed', 'type' => 'error', 'message' => 'Gagal menambah Categories baru']);
        }
    }
    public function update (Request $request, string $id) {

        try {
            $data = $request->validate([
                'name' => 'required|string|unique:Categories,name|max:255',
            ]);

            Categories::where('id',$id)->update($data);
                
            return redirect()->route('categories.index')
                ->with('floatingAlert', [
                    'title' => 'Update Categories Success', 
                    'type' => 'success', 
                    'message' => ""
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->withInput()->with('floatingAlert', ['title' => 'Gagal Update Categories', 'type' => 'error', 'message' => ""]);
        }
    }
    public function destroys (Request $request) {
        try {
            $ids = $request->query('id');
            Categories::destroy( $ids );
            $count = count($ids);
            return redirect()->route('categories.index')
                ->with('floatingAlert', ['title' => "Berhasil Hapus $count Categories", 'type' => 'success', 'message' => ""]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('floatingAlert', ['title' => 'Gagal Hapus Categories', 'type' => 'error', 'message' => ""]);
        }
    }
}